<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Models\DevelopmentConnection;
use App\Models\ProviderProfile;
use App\Models\SitePage;
use App\Models\User;
use App\Services\PersonalDevelopmentReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DevelopmentController extends Controller
{
    public function landing()
    {
        return view('development.landing');
    }

    public function login(Request $request): View|RedirectResponse
    {
        $request->validate(['solution' => ['nullable', 'string', 'max:180']]);
        $destination = $request->filled('solution')
            ? route('get-connected', ['solution' => $request->query('solution')])
            : route('development.home');
        if ($request->user()) {
            return redirect()->to($destination);
        }

        $request->session()->put('url.intended', $destination);

        return view('login');
    }

    public function getConnected(Request $request): View
    {
        $request->validate(['solution' => ['nullable', 'string', 'max:180']]);
        $solutionKey = $request->query('solution') ?: 'performance-confidence';
        $page = SitePage::query()->where('slug', 'solutions')->first();
        $solutions = ($page ?? new SitePage)->solutionDetails();
        abort_if(($page && ! $page->is_published) || ! isset($solutions[$solutionKey]) || ! $solutions[$solutionKey]['is_published'], 404);

        return view('development.child', [
            'register' => ! $request->user(),
            'solutionKey' => $solutionKey,
            'solution' => $solutions[$solutionKey],
        ]);
    }

    public function register(Request $request): View
    {
        return $this->getConnected($request);
    }

    public function storeAccount(Request $r): RedirectResponse
    {
        $data = $r->validate(['name' => 'required|string|max:255', 'email' => 'required|email|max:255|unique:users,email', 'phone' => 'required|string|max:30', 'password' => 'required|string|min:12|confirmed', 'terms' => 'accepted', 'location' => 'nullable|string|max:100', 'country_code' => ['nullable', Rule::in(['+254', '+256', '+255', '+250', '+1', '+44'])]] + $this->childRules());
        $user = DB::transaction(function () use ($data) {
            $u = User::create(['name' => $data['name'], 'email' => $data['email'], 'phone' => isset($data['country_code']) && ! str_starts_with($data['phone'], '+') ? $data['country_code'].ltrim($data['phone'], '0 ') : $data['phone'], 'location' => $data['location'] ?? null, 'password' => $data['password'], 'account_type' => 'Family']);
            $this->newChild($u->id, $data);

            return $u;
        });
        Auth::login($user);
        $r->session()->regenerate();

        $child = DevelopmentChild::where('user_id', $user->id)->firstOrFail();

        return redirect()->route('development.assessment', [$child, 1])->with('account_created_child', $child->id);
    }

    private function childRules(): array
    {
        $page = SitePage::query()->where('slug', 'solutions')->first();
        $solutions = $page && ! $page->is_published ? [] : array_filter(($page ?? new SitePage)->solutionDetails(), fn (array $solution): bool => $solution['is_published']);

        return [
            'connection_form' => ['nullable', 'in:1'],
            'quick_questions' => ['required_if:connection_form,1', 'nullable', 'array:reasons,current_level,timeline,relationship'],
            'quick_questions.reasons' => ['required_with:quick_questions', 'array', 'min:3', 'max:6'],
            'quick_questions.reasons.*' => ['string', 'distinct', Rule::in(config('development.connection.reasons'))],
            'quick_questions.current_level' => ['required_with:quick_questions', Rule::in(config('development.connection.levels'))],
            'quick_questions.timeline' => ['required_with:quick_questions', Rule::in(config('development.connection.timelines'))],
            'quick_questions.relationship' => ['required_with:quick_questions', Rule::in(['Parent', 'Guardian'])],
            'child_name' => ['required', 'string', 'max:120'],
            'age' => ['required', 'integer', 'min:5', 'max:25'],
            'grade' => ['required', 'string', 'max:60'],
            'school' => ['nullable', 'string', 'max:150'],
            'solution' => ['nullable', 'string', Rule::in(array_keys($solutions))],
            'pwd_status' => ['required_with:solution', 'nullable', Rule::in(['yes', 'no', 'prefer_not_to_say'])],
            'pwd_details' => ['exclude_unless:pwd_status,yes', 'nullable', 'string', 'max:250'],
            'support_notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    private function newChild(int $userId, array $data): DevelopmentChild
    {
        $child = DevelopmentChild::create(['user_id' => $userId, 'name' => $data['child_name'], 'age' => $data['age'], 'grade' => $data['grade'], 'school' => $data['school'] ?? null, 'solution' => $data['solution'] ?? null, 'pwd_status' => $data['pwd_status'] ?? null, 'pwd_details' => $data['pwd_details'] ?? null, 'support_notes' => $data['support_notes'] ?? null]);
        if (isset($data['quick_questions'])) {
            $child->assessments()->create(['answers' => ['connection' => $data['quick_questions']], 'step' => 1]);
        }

        return $child;
    }

    public function home(Request $r)
    {
        return view('development.home', ['children' => DevelopmentChild::where('user_id', $r->user()->id)->with('assessments')->get(), 'connections' => DevelopmentConnection::where('user_id', $r->user()->id)->with(['child', 'provider.user'])->latest()->get()]);
    }

    public function child(Request $request): View
    {
        return $this->getConnected($request);
    }

    public function storeChild(Request $r): RedirectResponse
    {
        $data = $r->validate($this->childRules());
        $child = DB::transaction(fn (): DevelopmentChild => $this->newChild($r->user()->id, $data));

        return redirect()->route('development.assessment', [$child, 1]);
    }

    public function journey(Request $request, int $child): RedirectResponse
    {
        $child = $this->ownedChild($request, $child);
        $assessment = $this->assessmentFor($child);
        if (data_get($assessment?->answers, 'reasons') || ($assessment?->step > 1 && ! data_get($assessment->answers, 'details_confirmed'))) {
            return redirect()->route('development.assessment', [$child, $assessment->step]);
        }
        if (! data_get($assessment?->answers, 'details_confirmed')) {
            return redirect()->route('development.child.details', $child);
        }
        foreach (config('development.mindset_questions') as $number => $question) {
            if (! data_get($assessment->answers, 'personal_development.'.$question['key'])) {
                return redirect()->route('development.mindset', [$child, $number]);
            }
        }

        return redirect()->route('development.assessment.complete', $child);
    }

    public function childDetails(Request $request, int $child): View
    {
        return view('development.child-details', ['child' => $this->ownedChild($request, $child), 'activeStage' => 2]);
    }

    public function saveChildDetails(Request $request, int $child): RedirectResponse
    {
        $child = $this->ownedChild($request, $child);
        $rules = array_intersect_key($this->childRules(), array_flip(['child_name', 'age', 'grade', 'school', 'pwd_status', 'pwd_details']));
        $rules['pwd_status'] = ['required', Rule::in(['yes', 'no', 'prefer_not_to_say'])];
        $data = $request->validate($rules);
        DB::transaction(function () use ($child, $data): void {
            $child->update(['name' => $data['child_name'], 'age' => $data['age'], 'grade' => $data['grade'], 'school' => $data['school'] ?? null, 'pwd_status' => $data['pwd_status'], 'pwd_details' => $data['pwd_details'] ?? null]);
            $assessment = $this->assessmentFor($child) ?? $child->assessments()->create(['answers' => [], 'step' => 1]);
            $assessment->update(['answers' => array_merge($assessment->answers ?? [], ['details_confirmed' => true]), 'consented_at' => null]);
        });

        return redirect()->route('development.mindset', [$child, 1]);
    }

    public function mindset(Request $request, int $child, int $question = 1): View|RedirectResponse
    {
        $questions = config('development.mindset_questions');
        abort_unless(isset($questions[$question]), 404);
        $child = $this->ownedChild($request, $child);
        $assessment = $this->assessmentFor($child);
        if (! data_get($assessment?->answers, 'details_confirmed')) {
            return redirect()->route('development.child.details', $child);
        }
        foreach ($questions as $number => $item) {
            if ($number < $question && ! data_get($assessment->answers, 'personal_development.'.$item['key'])) {
                return redirect()->route('development.mindset', [$child, $number]);
            }
        }

        return view('development.mindset-question', ['child' => $child, 'assessment' => $assessment, 'questionNumber' => $question, 'question' => $questions[$question], 'activeStage' => 3]);
    }

    public function saveMindset(Request $request, int $child, int $question): RedirectResponse
    {
        $questions = config('development.mindset_questions');
        abort_unless(isset($questions[$question]), 404);

        return DB::transaction(function () use ($request, $child, $question, $questions): RedirectResponse {
            $child = DevelopmentChild::query()->where('user_id', $request->user()->id)->lockForUpdate()->findOrFail($child);
            $assessment = $this->assessmentFor($child);
            abort_unless(data_get($assessment?->answers, 'details_confirmed'), 422);
            foreach ($questions as $number => $item) {
                abort_if($number < $question && ! data_get($assessment->answers, 'personal_development.'.$item['key']), 422);
            }
            $data = $request->validate(['answer' => ['required', Rule::in(array_keys($questions[$question]['options']))]]);
            $answers = $assessment->answers;
            $answers['personal_development'][$questions[$question]['key']] = $data['answer'];
            $assessment->update(['answers' => $answers, 'step' => $question === count($questions) ? max($assessment->step, 5) : $assessment->step, 'consented_at' => null]);

            return $question === count($questions)
                ? redirect()->route('development.assessment.complete', $child)
                : redirect()->route('development.mindset', [$child, $question + 1]);
        });
    }

    public function assessmentComplete(Request $request, int $child): View|RedirectResponse
    {
        $child = $this->ownedChild($request, $child);
        $assessment = $this->assessmentFor($child);
        if (! data_get($assessment?->answers, 'details_confirmed')) {
            return redirect()->route('development.child.details', $child);
        }
        $questions = config('development.mindset_questions');
        foreach ($questions as $number => $question) {
            if (! in_array(data_get($assessment->answers, 'personal_development.'.$question['key']), array_keys($question['options']), true)) {
                return redirect()->route('development.mindset', [$child, $number]);
            }
        }

        return view('development.assessment-complete', [
            'child' => $child, 'assessment' => $assessment, 'activeStage' => 4,
            'questionCount' => count($questions),
            'assessedAreas' => array_values(array_unique(array_column($questions, 'area'))),
        ]);
    }

    private function ownedChild(Request $r, int $id): DevelopmentChild
    {
        return DevelopmentChild::where('user_id', $r->user()->id)->findOrFail($id);
    }

    private function assessmentFor(DevelopmentChild $child): ?DevelopmentAssessment
    {
        return $child->assessments()->latest('id')->first();
    }

    public function assessment(Request $r, int $child, int $step = 1): View|RedirectResponse
    {
        abort_unless($step >= 1 && $step <= 5, 404);
        $child = $this->ownedChild($r, $child);
        $assessment = $this->assessmentFor($child);
        if ($step > ($assessment?->step ?? 1)) {
            return redirect()->route('development.assessment', [$child, $assessment?->step ?? 1]);
        }

        $registeredSolutionTitle = null;
        if ($step === 1 && (int) $r->session()->get('account_created_child') === $child->id) {
            $page = SitePage::query()->where('slug', 'solutions')->first();
            $solutions = ($page ?? new SitePage)->solutionDetails();
            $registeredSolutionTitle = $solutions[$child->solution ?? 'performance-confidence']['title'] ?? 'Your selected support';
        }

        return view('development.assessment', compact('child', 'assessment', 'step', 'registeredSolutionTitle'));
    }

    public function saveAssessment(Request $r, int $child, int $step): RedirectResponse
    {
        abort_unless($step >= 1 && $step <= 5, 404);

        return DB::transaction(function () use ($r, $child, $step): RedirectResponse {
            $child = DevelopmentChild::query()->where('user_id', $r->user()->id)->lockForUpdate()->findOrFail($child);
            $assessment = $this->assessmentFor($child);
            abort_if($step > ($assessment?->step ?? 1), 422);
            if ($step === 5) {
                $r->validate(['guardian' => 'accepted', 'consent' => 'accepted', 'sharing' => 'accepted']);
                $assessment->update(['consented_at' => now()]);

                return redirect()->route('development.plans', ['assessment' => $assessment->id]);
            }
            $rules = [];
            foreach (config("development.questions.$step") as $key => [$label, $type, $options]) {
                if (in_array($type, ['multi', 'goals'])) {
                    $rules[$key] = ['required', 'array', 'min:1', 'max:'.($type === 'goals' ? 3 : count($options))];
                    $rules[$key.'.*'] = ['string', 'distinct', Rule::in($options)];
                } elseif ($type === 'text') {
                    $rules[$key] = ['nullable', 'string', 'max:500'];
                } else {
                    $rules[$key] = ['required', Rule::in($options)];
                }
                if (in_array('Other', $options, true)) {
                    $rules[$key.'_other'] = [Rule::requiredIf(in_array('Other', (array) $r->input($key, []), true)), 'nullable', 'string', 'max:500'];
                }
            }
            $data = $r->validate($rules);
            foreach (config("development.questions.$step") as $key => [$label, $type, $options]) {
                if (in_array('Other', $options, true) && ! in_array('Other', (array) ($data[$key] ?? []), true)) {
                    $data[$key.'_other'] = null;
                }
            }
            foreach (['health', 'challenges'] as $key) {
                if (in_array('None', $data[$key] ?? [], true) && count($data[$key]) > 1) {
                    return back()->withErrors([$key => 'Choose None by itself, or select the relevant areas.'])->withInput();
                }
            }
            if (! $assessment) {
                $assessment = $child->assessments()->create(['answers' => []]);
            }
            $assessment->update([
                'answers' => array_merge($assessment->answers ?? [], $data),
                'step' => max($assessment->step, $step + 1),
                'consented_at' => null,
            ]);

            return redirect()->route('development.assessment', [$child, $step + 1]);
        });
    }

    public function report(Request $r, int $assessment, PersonalDevelopmentReport $personalReport): View
    {
        $assessment = DevelopmentAssessment::whereHas('child', fn ($q) => $q->where('user_id', $r->user()->id))->with('child')->findOrFail($assessment);
        abort_unless($assessment->consented_at, 404);

        if (data_get($assessment->answers, 'personal_development')) {
            return view('development.personal-report', [
                'assessment' => $assessment, 'child' => $assessment->child, 'activeStage' => 4,
                'report' => $personalReport->build($assessment),
            ]);
        }

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

    public function plans(Request $r): View
    {
        $data = $r->validate(['assessment' => 'nullable|integer', 'plan' => ['nullable', Rule::in(array_merge(array_keys(config('development.plans')), array_keys(config('development.report_subscriptions'))))], 'method' => ['nullable', Rule::in(['M-PESA', 'Card', 'Bank transfer'])]]);
        $assessment = isset($data['assessment']) ? DevelopmentAssessment::whereHas('child', fn ($query) => $query->where('user_id', $r->user()->id))->whereNotNull('consented_at')->with('child')->findOrFail($data['assessment']) : null;

        if (data_get($assessment?->answers, 'personal_development')) {
            return view('development.subscription-preview', ['assessment' => $assessment, 'child' => $assessment->child, 'activeStage' => 4]);
        }
        abort_if(isset($data['plan']) && array_key_exists($data['plan'], config('development.report_subscriptions')), 422);

        return view('development.plans', ['assessment' => $assessment, 'child' => $assessment?->child]);
    }

    public function checkout(Request $r)
    {
        $data = $r->validate(['plan' => ['required', Rule::in(array_merge(array_keys(config('development.plans')), array_keys(config('development.report_subscriptions'))))], 'method' => ['required', Rule::in(['M-PESA', 'Card', 'Bank transfer'])], 'assessment' => 'nullable|integer']);
        $data['assessment'] = isset($data['assessment']) ? DevelopmentAssessment::whereHas('child', fn ($query) => $query->where('user_id', $r->user()->id))->whereNotNull('consented_at')->findOrFail($data['assessment']) : null;

        abort_if(array_key_exists($data['plan'], config('development.report_subscriptions')) && ! data_get($data['assessment']?->answers, 'personal_development'), 422);

        return view('development.checkout', $data);
    }

    public function preview(Request $r, string $page)
    {
        abort_unless(in_array($page, ['dashboard', 'providers', 'provider', 'programme', 'payment', 'confirmation', 'success', 'tracking']), 404);
        $key = $r->query('programme', 'pap');
        abort_unless(is_string($key) && array_key_exists($key, config('development.programmes')), 404);

        return view('development.preview.'.$page, ['programme' => config('development.programmes.'.$key), 'programmeKey' => $key, 'preview' => true]);
    }
}
