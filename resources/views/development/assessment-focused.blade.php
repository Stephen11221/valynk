@include('development.partials.journey-header')

<main class="focus-shell">
    <aside class="focus-story">
        <img src="{{ asset('images/about/family.png') }}" alt="A parent supporting her child">
        <div><h2>Let’s<br>Understand<br><em>Better</em></h2><p>A few simple questions (3–5 minutes) to understand your child’s current situation so we can recommend the most relevant support.</p></div>
    </aside>
    <section class="focus-content" aria-label="Full assessment">
        <ol class="focus-stepper" aria-label="Your progress">
            @foreach(['Sign Up & Quick Questions', 'Child’s Details', 'Full Assessment', 'Preview Report', 'Match & Programmes'] as $label)
                <li class="{{ $loop->iteration < 3 ? 'completed' : '' }}" @if($loop->iteration === 3) aria-current="step" @endif><span>@if($loop->iteration < 3)<i class="fa-solid fa-check" aria-hidden="true"></i>@else{{ $loop->iteration }}@endif</span><p>{{ $label }}</p></li>
            @endforeach
        </ol>
        <div class="focus-columns">
            <form id="assessment-form" class="focus-card" method="POST" action="{{ route('development.assessment.save', [$child, $step]) }}" data-focused-assessment>
                @csrf
                <h1 class="focus-form-title" id="assessment-title">Take a Brief Assessment</h1>
                <p class="focus-learner">{{ $child->name }} · Age {{ $child->age }} · {{ $child->grade }}</p>
                @if($errors->any())<div class="connection-errors" role="alert"><strong>Please check your answers.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <p class="focus-question-count" data-focus-count aria-live="polite">Question 1 of {{ count(config('development.questions.1')) }}</p>
                <div class="focus-area"><i class="fa-solid fa-clipboard-question" aria-hidden="true"></i><span>Understanding Your Child’s Needs</span></div>
                @foreach(config('development.questions.1') as $key => [$label, $type, $options])
                    <fieldset class="assessment-question focus-question" data-question="{{ $key }}" @if($type === 'goals') data-max="3" @endif>
                        <legend>{{ $label }}</legend>
                        <p class="assessment-hint">{{ $type === 'goals' ? 'Select up to 3 options.' : ($type === 'multi' ? 'Select all that apply.' : 'Select one option.') }}</p>
                        <div class="assessment-options">
                            @foreach($options as $option)
                                <label class="assessment-option"><input type="{{ $type === 'radio' ? 'radio' : 'checkbox' }}" name="{{ $key }}{{ $type === 'radio' ? '' : '[]' }}" value="{{ $option }}" @checked(in_array($option, (array) old($key, data_get($assessment?->answers, $key, [])), true)) @required($type === 'radio')><span>{{ $option }}</span></label>
                            @endforeach
                        </div>
                        @if($type === 'goals')<p class="assessment-selection-count" role="status" data-selection-count></p>@endif
                        @if(in_array('Other', $options, true))
                            <div class="assessment-other" data-other-field @if(!in_array('Other', (array) old($key, data_get($assessment?->answers, $key, [])), true)) hidden @endif><label for="{{ $key }}-other">Please specify</label><textarea id="{{ $key }}-other" name="{{ $key }}_other" maxlength="500" rows="2">{{ old($key.'_other', data_get($assessment?->answers, $key.'_other')) }}</textarea></div>
                        @endif
                    </fieldset>
                @endforeach
                <p class="focus-validation" role="alert" data-focus-validation hidden>Please select an answer before continuing.</p>
                <div class="focus-actions"><a href="{{ route('dashboard') }}" data-focus-back><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back</a><button class="connection-submit" type="submit" data-focus-next>Continue Assessment <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></div>
                <noscript><p>Answer all questions, then select Continue Assessment to save your answers.</p></noscript>
            </form>
            <aside class="focus-panels" aria-label="Assessment information">
                <section class="focus-panel"><div class="focus-progress-heading"><h2>Your Progress</h2><span data-focus-progress-label>0 of {{ count(config('development.questions.1')) }} answered</span></div><progress data-focus-progress value="0" max="{{ count(config('development.questions.1')) }}" aria-label="Questions answered"></progress><p><i class="fa-regular fa-clock" aria-hidden="true"></i> About 3–5 minutes to complete</p></section>
                <section class="focus-panel"><h2>Focus Areas for This Assessment</h2><p>Your answers help us understand these areas and recommend relevant support.</p><ul>@foreach(['Confidence & self-belief' => 'brain', 'Focus and learning habits' => 'bullseye', 'Motivation and goals' => 'flag'] as $label => $icon)<li><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>{{ $label }}</li>@endforeach</ul></section>
                <section class="focus-panel focus-safe"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><div><h2>Your Information is Safe</h2><p>Your responses are private and only used to connect you with the right support, providers and programmes.</p></div></section>
            </aside>
        </div>
    </section>
</main>
