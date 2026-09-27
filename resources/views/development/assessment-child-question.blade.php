@php
    [$questionLabel, $questionType, $questionOptions] = config('development.questions.4.'.$questionKey);
    $icons = ['None' => 'circle', 'Physical Disability' => 'wheelchair', 'Visual Impairment' => 'eye', 'Hearing Impairment' => 'ear-listen', 'Neurodivergent' => 'brain', 'Chronic Illness' => 'heart-pulse', 'Learning Difference' => 'book-open', 'Other' => 'ellipsis', 'Focus & Concentration' => 'bullseye', 'Confidence & Self-Esteem' => 'user', 'Academic Performance' => 'book-open', 'Behaviour & Discipline' => 'users', 'Emotional Wellbeing' => 'heart', 'Social Skills & Relationships' => 'comment-dots', 'Time Management' => 'clock'];
    $examples = ['Physical Disability' => '(e.g. mobility)', 'Neurodivergent' => '(e.g. autism, ADHD)', 'Chronic Illness' => '(e.g. diabetes, epilepsy)', 'Learning Difference' => '(e.g. dyslexia)', 'Other' => '(Please specify)'];
@endphp
<fieldset class="assessment-question child-question child-{{ $questionKey }}" data-question="{{ $questionKey }}">
    <legend><span>{{ $number }}.</span> {{ $questionLabel }}@if($questionType === 'multi') <small>(Select all that apply)</small>@endif</legend>
    @if($questionType === 'text')
        <div class="support-expectations-input"><textarea id="answer-additional" name="additional" maxlength="500" rows="5" data-counter aria-label="Additional information (optional)" aria-describedby="count-additional" placeholder="e.g. interests, strengths, specific concerns, goals, etc.">{{ old('additional', data_get($assessment?->answers, 'additional')) }}</textarea><output id="count-additional" class="assessment-counter" for="answer-additional">0/500</output></div>
    @else
        <div class="assessment-options {{ $questionType === 'radio' ? 'assessment-radios support-radio-options' : 'support-card-options' }}">
            @foreach($questionOptions as $option)
                <label class="assessment-option">
                    <input type="{{ $questionType === 'multi' ? 'checkbox' : 'radio' }}" name="{{ $questionKey }}{{ $questionType === 'multi' ? '[]' : '' }}" value="{{ $option }}" @checked(in_array($option, (array) old($questionKey, data_get($assessment?->answers, $questionKey, [])), true)) @required($questionType === 'radio')>
                    @if($questionType === 'multi')<i class="fa-solid fa-{{ $icons[$option] ?? 'circle-check' }}" aria-hidden="true"></i>@endif
                    <span>{{ $option }}@if(isset($examples[$option]))<small>{{ $examples[$option] }}</small>@endif</span>
                </label>
            @endforeach
        </div>
        @if(in_array('Other', $questionOptions, true))
            <div class="assessment-other" data-other-field @if(!in_array('Other', (array) old($questionKey, data_get($assessment?->answers, $questionKey, [])), true)) hidden @endif><label for="{{ $questionKey }}-other">Please specify</label><textarea id="{{ $questionKey }}-other" name="{{ $questionKey }}_other" maxlength="500" rows="2">{{ old($questionKey.'_other', data_get($assessment?->answers, $questionKey.'_other')) }}</textarea></div>
        @endif
    @endif
</fieldset>
