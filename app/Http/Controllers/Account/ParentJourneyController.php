<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentAssessment;
use App\Models\DevelopmentChild;
use App\Services\PersonalDevelopmentReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ParentJourneyController extends Controller
{
    private const SCREENS = [
        'ready' => 'Your Account is Ready', 'child' => 'Child’s Details',
        'question-1' => 'Assessment: Confidence', 'question-2' => 'Assessment: Resilience',
        'question-3' => 'Assessment: Focus', 'question-4' => 'Assessment: Routines',
        'question-5' => 'Assessment: Motivation', 'question-6' => 'Assessment: Goals',
        'complete' => 'Assessment Complete', 'report' => 'Your Child’s Report',
        'subscription' => 'Subscription Preview', 'matches' => 'Matched Provider & Programmes',
        'selection' => 'Select Programme', 'programme' => 'Programme Details',
        'participant' => 'Participant Details', 'intake' => 'Choose Intake & Payment',
        'review' => 'Review Your Selection', 'confirmation' => 'Booking Confirmation',
        'dashboard' => 'Parent Dashboard', 'tracking' => 'Progress Tracking',
    ];

    public function index(): View
    {
        return view('development.parent-screens', ['screens' => self::SCREENS]);
    }

    public function show(Request $request, string $screen, PersonalDevelopmentReport $reports): View
    {
        abort_unless(isset(self::SCREENS[$screen]), 404);
        $request->validate(['programme' => ['nullable', Rule::in(array_keys(config('development.programmes')))]]);
        $draft = $request->session()->get('parent_journey_preview', []);
        $programmeKey = $request->query('programme', $draft['programme'] ?? 'gap');
        $programmes = array_replace_recursive(config('development.programmes'), config('development.parent_reference_programmes'));
        $child = new DevelopmentChild(['name' => $draft['child_name'] ?? 'Sarah Kamau', 'age' => $draft['age'] ?? 10, 'grade' => $draft['grade'] ?? 'Grade 5', 'school' => $draft['school'] ?? 'Greenfield Academy', 'pwd_status' => $draft['pwd_status'] ?? 'no']);
        $child->id = 1;
        $answers = [];
        foreach (config('development.mindset_questions') as $question) {
            $answers[$question['key']] = $draft['answers'][$question['key']] ?? array_keys($question['options'])[1];
        }
        $assessment = new DevelopmentAssessment(['answers' => ['personal_development' => $answers], 'consented_at' => now()]);
        $assessment->id = 1;
        $assessment->setRelation('child', $child);
        $questionNumber = str_starts_with($screen, 'question-') ? (int) substr($screen, -1) : null;
        $screenUrl = fn (string $page, array $parameters = []): string => route('development.screens.show', array_replace(['screen' => $page, 'programme' => $programmeKey], $parameters));
        $data = [
            'screen' => $screen, 'screenPreview' => true, 'child' => $child, 'assessment' => $assessment,
            'screenUrl' => $screenUrl, 'programmeKey' => $programmeKey, 'programme' => $programmes[$programmeKey],
            'programmes' => $programmes, 'draft' => $draft,
            'activeStage' => $screen === 'child' || $screen === 'ready' ? 2 : ($questionNumber ? 3 : ($screen === 'matches' ? 5 : 4)),
            'questionNumber' => $questionNumber, 'question' => $questionNumber ? config('development.mindset_questions.'.$questionNumber) : null,
            'questionCount' => count(config('development.mindset_questions')),
            'assessedAreas' => array_values(array_unique(array_column(config('development.mindset_questions'), 'area'))),
            'report' => $reports->build($assessment),
            'formAction' => route('development.screens.save', $screen),
            'backUrl' => $screenUrl($questionNumber ? ($questionNumber === 1 ? 'child' : 'question-'.($questionNumber - 1)) : 'ready'),
            'reportUrl' => $screenUrl('report'), 'completeUrl' => $screenUrl('complete'), 'matchesUrl' => $screenUrl('matches'),
            'plansUrl' => $screenUrl('subscription'), 'checkoutUrl' => $screenUrl('selection'),
            'previousQuestionUrl' => $screenUrl('question-6'), 'dashboardUrl' => $screenUrl('dashboard'),
            'registeredSolutionTitle' => 'Performance, Confidence & Personal Development', 'continueUrl' => $screenUrl('child'),
        ];
        $view = match ($screen) {
            'child' => 'child-details', 'complete' => 'assessment-complete', 'report' => 'personal-report',
            'subscription' => 'subscription-preview', 'ready' => 'preview.account-ready',
            'dashboard', 'tracking' => 'preview.parent-dashboard',
            default => $questionNumber ? 'mindset-question' : 'programme-journey',
        };

        return view('development.'.$view, $data + $this->programmeData($programmeKey, $draft, true));
    }

    public function save(Request $request, string $screen): RedirectResponse
    {
        abort_unless(in_array($screen, ['child', 'selection', 'participant', 'intake', 'review']) || preg_match('/^question-[1-6]$/', $screen), 404);
        $draft = $request->session()->get('parent_journey_preview', []);
        if ($screen === 'child') {
            $data = $request->validate(['child_name' => 'required|string|max:120', 'age' => 'required|integer|min:5|max:25', 'grade' => 'required|string|max:60', 'school' => 'nullable|string|max:150', 'pwd_status' => ['required', Rule::in(['yes', 'no', 'prefer_not_to_say'])]]);
            $draft = array_replace($draft, $data);
            $next = 'question-1';
        } elseif (str_starts_with($screen, 'question-')) {
            $number = (int) substr($screen, -1);
            $question = config('development.mindset_questions.'.$number);
            $data = $request->validate(['answer' => ['required', Rule::in(array_keys($question['options']))]]);
            $draft['answers'][$question['key']] = $data['answer'];
            $next = $number === 6 ? 'complete' : 'question-'.($number + 1);
        } else {
            $data = $request->validate($this->stageRules($screen));
            $draft = array_replace($draft, $data);
            $next = ['selection' => 'programme', 'participant' => 'intake', 'intake' => 'review', 'review' => 'confirmation'][$screen];
        }
        $request->session()->put('parent_journey_preview', $draft);

        return redirect()->route('development.screens.show', ['screen' => $next, 'programme' => $draft['programme'] ?? 'gap']);
    }

    public function enquiry(Request $request, int $assessment, string $screen): View|RedirectResponse
    {
        abort_unless(in_array($screen, ['selection', 'programme', 'participant', 'intake', 'review', 'confirmation']), 404);
        $assessment = $this->ownedAssessment($request, $assessment);
        $draft = data_get($assessment->answers, 'programme_enquiry', []);
        $eligible = $this->eligibleProgrammes($assessment);
        $request->validate(['programme' => ['nullable', Rule::in(array_keys($eligible))]]);
        $programmeKey = $screen === 'selection' ? $request->query('programme', $draft['programme'] ?? array_key_first($eligible)) : ($draft['programme'] ?? array_key_first($eligible));
        if (! isset($eligible[$programmeKey])) {
            $programmeKey = array_key_first($eligible);
            if ($screen !== 'selection') {
                return redirect()->route('development.enquiry', [$assessment, 'selection']);
            }
        }
        abort_unless($programmeKey, 404);
        if ($screen !== 'selection' && ! isset($draft['programme'])) {
            return redirect()->route('development.enquiry', [$assessment, 'selection']);
        }
        if (in_array($screen, ['review', 'confirmation']) && ! isset($draft['intake'], $draft['participant_confirmed'])) {
            return redirect()->route('development.enquiry', [$assessment, 'participant']);
        }
        if ($screen === 'confirmation' && ! isset($draft['requested_at'])) {
            return redirect()->route('development.enquiry', [$assessment, 'review']);
        }
        $screenUrl = fn (string $page, array $parameters = []): string => route('development.enquiry', [$assessment, $page] + $parameters);

        return view('development.programme-journey', [
            'screen' => $screen, 'screenPreview' => false, 'child' => $assessment->child, 'assessment' => $assessment,
            'activeStage' => 5, 'screenUrl' => $screenUrl, 'draft' => $draft,
            'programmeKey' => $programmeKey, 'programme' => config('development.programmes.'.$programmeKey),
            'programmes' => $this->eligibleProgrammes($assessment), 'formAction' => route('development.enquiry.save', [$assessment, $screen]),
            'matchesUrl' => route('development.matches', $assessment), 'dashboardUrl' => route('dashboard'),
        ] + $this->programmeData($programmeKey, $draft, false));
    }

    public function saveEnquiry(Request $request, int $assessment, string $screen): RedirectResponse
    {
        abort_unless(in_array($screen, ['selection', 'participant', 'intake', 'review']), 404);
        $next = DB::transaction(function () use ($request, $assessment, $screen): string {
            $assessment = $this->ownedAssessment($request, $assessment, true);
            $draft = data_get($assessment->answers, 'programme_enquiry', []);
            abort_if($screen !== 'selection' && ! isset($this->eligibleProgrammes($assessment)[$draft['programme'] ?? '']), 422);
            abort_if(in_array($screen, ['intake', 'review']) && ! isset($draft['participant_confirmed']), 422);
            abort_if($screen === 'review' && ! isset($draft['intake']), 422);
            $rules = $this->stageRules($screen);
            if ($screen === 'selection') {
                $rules['programme'] = ['required', Rule::in(array_keys($this->eligibleProgrammes($assessment)))];
            }
            $data = $request->validate($rules);
            $draft = $screen === 'selection' ? $data : array_replace($draft, $data);
            unset($draft['requested_at']);
            if ($screen === 'review') {
                $draft['requested_at'] = now()->toIso8601String();
            }
            $answers = $assessment->answers;
            $answers['programme_enquiry'] = $draft;
            $assessment->update(['answers' => $answers]);

            return ['selection' => 'programme', 'participant' => 'intake', 'intake' => 'review', 'review' => 'confirmation'][$screen];
        });

        return redirect()->route('development.enquiry', [$assessment, $next]);
    }

    private function ownedAssessment(Request $request, int $assessment, bool $lock = false): DevelopmentAssessment
    {
        $query = DevelopmentAssessment::query()->whereHas('child', fn ($query) => $query->where('user_id', $request->user()->id))
            ->whereNotNull('consented_at')->with('child');
        if ($lock) {
            $query->lockForUpdate();
        }

        return $query->findOrFail($assessment);
    }

    /** @return array<string, array<string, mixed>> */
    private function eligibleProgrammes(DevelopmentAssessment $assessment): array
    {
        return array_filter(config('development.programmes'), fn (array $programme): bool => $assessment->child->age >= $programme['min'] && $assessment->child->age <= $programme['max']);
    }

    /** @return array<string, mixed> */
    private function stageRules(string $screen): array
    {
        return match ($screen) {
            'selection' => ['programme' => ['required', Rule::in(array_keys(config('development.programmes')))]],
            'participant' => ['participant_confirmed' => 'accepted', 'contact_phone' => 'required|string|max:30', 'participant_notes' => 'nullable|string|max:500'],
            'intake' => ['intake' => ['required', Rule::in(['listed', 'alternative'])], 'payment_option' => ['required', Rule::in(['commitment', 'full'])], 'payment_method' => ['required', Rule::in(['M-PESA', 'Card', 'Bank transfer'])]],
            'review' => ['enquiry_consent' => 'accepted'],
        };
    }

    /** @param array<string, mixed> $draft
     * @return array<string, mixed>
     */
    private function programmeData(string $key, array $draft, bool $preview): array
    {
        $programme = config('development.programmes.'.$key);
        if ($preview) {
            $programme = array_replace($programme, config('development.parent_reference_programmes.'.$key, []));
        }
        $discount = $preview ? (int) round($programme['fee'] * .15) : 0;
        $total = $programme['fee'] - $discount;
        $commitment = min(5000, $total);
        $paid = ($draft['payment_option'] ?? 'commitment') === 'full' ? $total : $commitment;

        return [
            'programmeImage' => asset($programme['image'] === 'student' ? 'images/solutions/confidence-hero.png' : 'images/about/family.png'),
            'discount' => $discount, 'total' => $total, 'commitment' => $commitment,
            'amountDue' => $paid, 'balance' => $total - $paid,
            'intakes' => ['listed' => $programme['date'], 'alternative' => 'Request another intake'],
            'benefits' => config('development.programme_benefits'),
        ];
    }
}
