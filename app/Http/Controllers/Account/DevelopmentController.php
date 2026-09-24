<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Models\DevelopmentConnection;
use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DevelopmentController extends Controller
{
    public function landing()
    {
        return view('development.landing');
    }

    public function register()
    {
        return view('development.child', ['register' => true]);
    }

    public function storeAccount(Request $r)
    {
        $data = $r->validate(['name' => 'required|string|max:255', 'email' => 'required|email|max:255|unique:users,email', 'phone' => 'required|string|max:30', 'password' => 'required|string|min:12|confirmed', 'terms' => 'accepted'] + $this->childRules());
        $user = DB::transaction(function () use ($data) {
            $u = User::create(['name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'], 'password' => $data['password'], 'account_type' => 'Family']);
            $this->newChild($u->id, $data);

            return $u;
        });
        Auth::login($user);
        $r->session()->regenerate();

        return redirect()->route('development.home');
    }

    private function childRules(): array
    {
        return ['child_name' => 'required|string|max:120', 'age' => 'required|integer|min:5|max:25', 'grade' => 'required|string|max:60', 'school' => 'nullable|string|max:150'];
    }

    private function newChild(int $userId, array $data): DevelopmentChild
    {
        return DevelopmentChild::create(['user_id' => $userId, 'name' => $data['child_name'], 'age' => $data['age'], 'grade' => $data['grade'], 'school' => $data['school'] ?? null]);
    }

    public function home(Request $r)
    {
        return view('development.home', ['children' => DevelopmentChild::where('user_id', $r->user()->id)->with('assessments')->get(), 'connections' => DevelopmentConnection::where('user_id', $r->user()->id)->with(['child', 'provider.user'])->latest()->get()]);
    }

    public function child()
    {
        return view('development.child', ['register' => false]);
    }

    public function storeChild(Request $r)
    {
        $data = $r->validate($this->childRules());
        $child = $this->newChild($r->user()->id, $data);

        return redirect()->route('development.assessment', [$child, 1]);
    }

    private function ownedChild(Request $r, int $id): DevelopmentChild
    {
        return DevelopmentChild::where('user_id', $r->user()->id)->findOrFail($id);
    }

    private function assessmentFor(DevelopmentChild $child): ?DevelopmentAssessment
    {
        return $child->assessments()->latest('id')->first();
    }

    public function assessment(Request $r, int $child, int $step = 1)
    {
        abort_unless($step >= 1 && $step <= 5, 404);
        $child = $this->ownedChild($r, $child);
        $assessment = $this->assessmentFor($child);
        if ($step > ($assessment?->step ?? 1)) {
            return redirect()->route('development.assessment', [$child, $assessment?->step ?? 1]);
        }

        return view('development.assessment', compact('child', 'assessment', 'step'));
    }

    public function saveAssessment(Request $r, int $child, int $step)
    {
        abort_unless($step >= 1 && $step <= 5, 404);
        $child = $this->ownedChild($r, $child);
        $assessment = $this->assessmentFor($child);
        abort_if($step > ($assessment?->step ?? 1), 422);
        if ($step === 5) {
            $r->validate(['guardian' => 'accepted', 'consent' => 'accepted', 'sharing' => 'accepted']);
            $assessment->update(['consented_at' => now()]);

            return redirect()->route('development.report', $assessment);
        }
        $rules = [];
        foreach (config("development.questions.$step") as $key => [$label,$type,$options]) {
            if (in_array($type, ['multi', 'goals'])) {
                $rules[$key] = ['required', 'array', 'min:1', 'max:'.($type === 'goals' ? 3 : count($options))];
                $rules[$key.'.*'] = ['string', 'distinct', Rule::in($options)];
            } elseif ($type === 'text') {
                $rules[$key] = ['nullable', 'string', 'max:500'];
            } else {
                $rules[$key] = ['required', Rule::in($options)];
            }
        }
        $data = $r->validate($rules);
        foreach (['health', 'challenges'] as $key) {
            if (in_array('None', $data[$key] ?? []) && count($data[$key]) > 1) {
                return back()->withErrors([$key => 'Choose None by itself, or select the relevant areas.'])->withInput();
            }
        }
        if (! $assessment) {
            $assessment = $child->assessments()->create(['answers' => []]);
        }
        $assessment->update(['answers' => array_merge($assessment->answers ?? [], $data), 'step' => max($assessment->step, $step + 1), 'consented_at' => null]);

        return redirect()->route('development.assessment', [$child, $step + 1]);
    }

    public function report(Request $r, int $assessment)
    {
        $assessment = DevelopmentAssessment::whereHas('child', fn ($q) => $q->where('user_id', $r->user()->id))->with('child')->findOrFail($assessment);
        abort_unless($assessment->consented_at, 404);

        return view('development.report', ['assessment' => $assessment, 'sample' => false]);
    }

    public function sample()
    {
        return view('development.report', ['sample' => true]);
    }

    public function samplePdf()
    {
        return response()->download(public_path('development-assets/sample-report.pdf'), 'VALYNK_Sample_Full_Report.pdf');
    }

    public function providers(Request $r)
    {
        $filters = $r->validate(['q' => 'nullable|string|max:100', 'category' => 'nullable|string|max:100', 'location' => 'nullable|string|max:100']);
        $base = ProviderProfile::where('status', 'Approved')->where('verification', 'Verified')->whereHas('user', fn ($q) => $q->where('account_type', 'Provider'));
        $categories = (clone $base)->whereNotNull('category')->distinct()->pluck('category');
        $providers = $base->with('user')->when($filters['q'] ?? null, fn ($q, $s) => $q->where(fn ($q) => $q->where('service', 'like', "%$s%")->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%$s%"))))->when($filters['category'] ?? null, fn ($q, $s) => $q->where('category', $s))->when($filters['location'] ?? null, fn ($q, $s) => $q->whereHas('user', fn ($u) => $u->where('location', 'like', "%$s%")))->paginate(12)->withQueryString();

        return view('development.providers', compact('providers', 'categories'));
    }

    public function provider(Request $r, int $provider)
    {
        $provider = ProviderProfile::with('user')->where('status', 'Approved')->where('verification', 'Verified')->findOrFail($provider);

        return view('development.provider', ['provider' => $provider, 'children' => DevelopmentChild::where('user_id', $r->user()->id)->get()]);
    }

    public function connect(Request $r, int $provider)
    {
        ProviderProfile::where('status', 'Approved')->where('verification', 'Verified')->findOrFail($provider);
        $data = $r->validate(['child_id' => 'required|integer', 'consent' => 'accepted']);
        $child = $this->ownedChild($r, $data['child_id']);
        DevelopmentConnection::firstOrCreate(['user_id' => $r->user()->id, 'provider_profile_id' => $provider, 'development_child_id' => $child->id], ['status' => 'Requested']);

        return redirect()->route('development.bookings')->with('status', 'Connection request saved. It is awaiting follow-up; no booking or payment has been confirmed.');
    }

    public function bookings(Request $r)
    {
        return view('development.bookings', ['connections' => DevelopmentConnection::where('user_id', $r->user()->id)->with(['provider.user', 'child'])->latest()->get()]);
    }

    public function plans()
    {
        return view('development.plans');
    }

    public function checkout(Request $r)
    {
        $data = $r->validate(['plan' => ['required', Rule::in(array_keys(config('development.plans')))], 'method' => ['required', Rule::in(['M-PESA', 'Card', 'Bank transfer'])]]);

        return view('development.checkout', $data);
    }

    public function preview(Request $r, string $page)
    {
        abort_unless(in_array($page, ['dashboard', 'providers', 'provider', 'programme', 'payment', 'confirmation', 'success', 'tracking']), 404);
        $key = $r->query('programme','pap');
        abort_unless(is_string($key) && array_key_exists($key,config('development.programmes')),404);

        return view('development.preview.'.$page,['programme' => config('development.programmes.'.$key), 'programmeKey' => $key, 'preview' => true]);
    }
}
