<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentChild;
use App\Models\DevelopmentConnection;
use App\Models\SitePage;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const DASHBOARD_VIEWS = [
        'Individual' => 'account.individual-dashboard',
        'Family' => 'account.family-dashboard',
        'Provider' => 'account.provider-dashboard',
        'Institution' => 'account.institution-dashboard',
        'Partner / Other' => 'account.dashboard',
    ];

    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $user->load('providerProfile');

        $dashboardView = self::DASHBOARD_VIEWS[$user->account_type] ?? 'account.dashboard';
        $dashboardData = ['user' => $user];
        if (in_array($dashboardView, ['account.dashboard', 'account.family-dashboard'], true)) {
            $dashboardData += $this->familyData($user);
        }

        return view($dashboardView, $dashboardData);
    }

    public function section(Request $request, string $page): View|RedirectResponse
    {
        $user = $request->user();
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        abort_unless(in_array($user->account_type, ['Family', 'Partner / Other'], true), 403);
        abort_unless(in_array($page, ['assessments', 'payments', 'progress', 'messages', 'programmes', 'settings', 'help'], true), 404);

        return view('account.sections', ['user' => $user, 'page' => $page] + $this->familyData($user));
    }

    /** @return array<string, mixed> */
    private function familyData(User $user): array
    {
        $children = DevelopmentChild::query()->where('user_id', $user->id)->with('assessments')->latest()->get();
        $connections = DevelopmentConnection::query()->where('user_id', $user->id)
            ->whereHas('child', fn (Builder $query) => $query->where('user_id', $user->id))
            ->with(['provider.user', 'child'])->latest()->limit(5)->get();
        $selectedChild = $children->first();
        $latestAssessment = $selectedChild?->assessments->sortByDesc('id')->first();
        $assessmentProgress = $latestAssessment?->consented_at ? 100 : min(100, max(0, (($latestAssessment?->step ?? 1) - 1) * 25));
        $solutionPage = SitePage::query()->where('slug', 'solutions')->first();
        $solutions = ($solutionPage ?? new SitePage)->solutionDetails();
        $selectedSolution = $solutions[$selectedChild?->solution ?? 'performance-confidence'] ?? null;
        $publishedSolutions = $solutionPage && ! $solutionPage->is_published ? [] : array_filter($solutions, fn (array $solution): bool => $solution['is_published']);

        return compact('children', 'connections', 'selectedChild', 'latestAssessment', 'assessmentProgress', 'selectedSolution', 'publishedSolutions');
    }

    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if ($user->is_admin) {
            return redirect()->route('admin.users.edit', $user);
        }

        return view('account.profile', ['user' => $user->load('providerProfile')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_if($user->is_admin, 403);
        $emailChanged = strcasecmp((string) $request->input('email'), $user->email) !== 0;
        $passwordChanged = filled($request->input('password'));

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:100'],
            'current_password' => [Rule::requiredIf($emailChanged || $passwordChanged), 'nullable', 'current_password'],
            'password' => ['nullable', 'string', 'min:12', 'confirmed'],
        ];
        if ($user->account_type === 'Provider') {
            $rules['service'] = ['required', 'string', 'max:255'];
            $rules['category'] = ['required', 'string', 'max:255'];
        }
        $data = $request->validate($rules);

        DB::transaction(function () use ($data, $emailChanged, $user): void {
            $updates = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'location' => $data['location'] ?? null,
            ];
            if (filled($data['password'] ?? null)) {
                $updates['password'] = $data['password'];
            }
            $user->update($updates);
            if ($emailChanged) {
                $user->forceFill(['email_verified_at' => null])->save();
            }
            if ($user->account_type === 'Provider') {
                $user->providerProfile()->updateOrCreate([], [
                    'service' => $data['service'],
                    'category' => $data['category'],
                ]);
            }
        });

        return redirect()->route('dashboard')->with('status', 'Your profile was updated.');
    }
}
