<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProviderController extends Controller
{
    private const STATUSES = ['Pending', 'Approved', 'Rejected'];

    private const VERIFICATIONS = ['Not Verified', 'Under Review', 'Verified'];

    public function index(Request $request): View
    {
        $filters = $this->filters($request);
        $perPage = (int) ($filters['per_page'] ?? 10);
        $providers = $this->providerQuery($filters)
            ->select('users.*')
            ->with('providerProfile')
            ->orderByDesc('users.created_at')
            ->paginate($perPage)
            ->withQueryString();

        $base = User::query()->where('account_type', 'Provider');
        $total = (clone $base)->count();
        $approved = (clone $base)->whereHas('providerProfile', fn (Builder $query) => $query->where('status', 'Approved'))->count();
        $rejected = (clone $base)->whereHas('providerProfile', fn (Builder $query) => $query->where('status', 'Rejected'))->count();
        $verified = (clone $base)->whereHas('providerProfile', fn (Builder $query) => $query->where('verification', 'Verified'))->count();
        $underReview = (clone $base)->whereHas('providerProfile', fn (Builder $query) => $query->where('verification', 'Under Review'))->count();
        $pending = $total - $approved - $rejected;

        return view('admin.providers', [
            'providers' => $providers,
            'filters' => $filters,
            'categories' => ProviderProfile::query()
                ->whereHas('user', fn (Builder $query) => $query->where('account_type', 'Provider'))
                ->whereNotNull('category')->distinct()->orderBy('category')->pluck('category'),
            'stats' => compact('total', 'approved', 'pending', 'rejected', 'verified'),
            'statusBreakdown' => [
                ['label' => 'Approved', 'count' => $approved, 'color' => '#10B981'],
                ['label' => 'Pending', 'count' => $pending, 'color' => '#F59E0B'],
                ['label' => 'Rejected', 'count' => $rejected, 'color' => '#EF4444'],
            ],
            'verificationBreakdown' => [
                ['label' => 'Verified', 'count' => $verified, 'color' => '#10B981'],
                ['label' => 'Under Review', 'count' => $underReview, 'color' => '#F59E0B'],
                ['label' => 'Not Verified', 'count' => $total - $verified - $underReview, 'color' => '#EF4444'],
            ],
            'recentProviders' => (clone $base)->with('providerProfile')->latest()->limit(5)->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.providers-form', [
            'provider' => null,
            'statuses' => self::STATUSES,
            'verifications' => self::VERIFICATIONS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProvider($request);
        $user = DB::transaction(function () use ($data): User {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'location' => $data['location'] ?? null,
                'account_type' => 'Provider',
                'password' => $data['password'],
            ]);
            $user->providerProfile()->create($this->profileData($data));

            return $user;
        });

        return redirect()->route('admin.providers')->with('status', "{$user->name} was added.");
    }

    public function edit(User $provider): View
    {
        abort_unless($provider->account_type === 'Provider', 404);

        return view('admin.providers-form', [
            'provider' => $provider->load('providerProfile'),
            'statuses' => self::STATUSES,
            'verifications' => self::VERIFICATIONS,
        ]);
    }

    public function update(Request $request, User $provider): RedirectResponse
    {
        abort_unless($provider->account_type === 'Provider', 404);
        $data = $this->validateProvider($request, $provider);

        DB::transaction(function () use ($data, $provider): void {
            $provider->update(array_filter([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'location' => $data['location'] ?? null,
                'password' => $data['password'] ?? null,
            ], fn ($value, $key) => $key !== 'password' || filled($value), ARRAY_FILTER_USE_BOTH));
            $provider->providerProfile()->updateOrCreate([], $this->profileData($data));
        });

        return redirect()->route('admin.providers')->with('status', "{$provider->name} was updated.");
    }

    public function export(Request $request): StreamedResponse
    {
        $filters = $this->filters($request);
        $query = $this->providerQuery($filters)
            ->select('users.name', 'users.email', 'users.phone', 'users.location', 'users.created_at',
                'provider_profiles.service', 'provider_profiles.category', 'provider_profiles.status', 'provider_profiles.verification')
            ->orderBy('users.name');

        return response()->streamDownload(function () use ($query): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Name', 'Email', 'Phone', 'Location', 'Service', 'Category', 'Status', 'Verification', 'Joined']);
            foreach ($query->cursor() as $provider) {
                fputcsv($output, [
                    $this->csvCell($provider->name),
                    $this->csvCell($provider->email),
                    $this->csvCell($provider->phone),
                    $this->csvCell($provider->location),
                    $this->csvCell($provider->service),
                    $this->csvCell($provider->category),
                    $this->csvCell($provider->status ?? 'Pending'),
                    $this->csvCell($provider->verification ?? 'Not Verified'),
                    $provider->created_at?->toDateString(),
                ]);
            }
            fclose($output);
        }, 'providers.csv', ['Content-Type' => 'text/csv']);
    }

    private function filters(Request $request): array
    {
        return $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(self::STATUSES)],
            'verification' => ['nullable', Rule::in(self::VERIFICATIONS)],
            'per_page' => ['nullable', Rule::in([10, 25, 50])],
        ]);
    }

    private function providerQuery(array $filters): Builder
    {
        return User::query()
            ->where('users.account_type', 'Provider')
            ->leftJoin('provider_profiles', 'provider_profiles.user_id', '=', 'users.id')
            ->when(filled($filters['search'] ?? null), function (Builder $query) use ($filters): void {
                $search = $filters['search'];
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('users.name', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('provider_profiles.service', 'like', "%{$search}%");
                });
            })
            ->when(filled($filters['category'] ?? null), fn (Builder $query) => $query->where('provider_profiles.category', $filters['category']))
            ->when(filled($filters['status'] ?? null), fn (Builder $query) => $query->whereRaw("COALESCE(provider_profiles.status, 'Pending') = ?", [$filters['status']]))
            ->when(filled($filters['verification'] ?? null), fn (Builder $query) => $query->whereRaw("COALESCE(provider_profiles.verification, 'Not Verified') = ?", [$filters['verification']]));
    }

    private function validateProvider(Request $request, ?User $provider = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($provider)],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:100'],
            'service' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(self::STATUSES)],
            'verification' => ['required', Rule::in(self::VERIFICATIONS)],
            'password' => [$provider ? 'nullable' : 'required', 'string', 'min:12', 'confirmed'],
        ]);
    }

    private function profileData(array $data): array
    {
        return [
            'service' => $data['service'],
            'category' => $data['category'],
            'status' => $data['status'],
            'verification' => $data['verification'],
        ];
    }

    private function csvCell(?string $value): string
    {
        $value = (string) $value;

        return preg_match('/^[\x00-\x20]*[=+\-@]/', $value) ? "'{$value}" : $value;
    }
}
