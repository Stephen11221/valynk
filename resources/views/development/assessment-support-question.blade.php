@php([$questionLabel, $questionType, $questionOptions] = config('development.questions.3.'.$questionKey))
<fieldset class="assessment-question support-question support-{{ $questionKey }}" data-question="{{ $questionKey }}">
    <legend><span>{{ $number }}.</span> {{ $questionLabel }}@if($questionKey === 'support') <small>(Select all that apply)</small>@elseif($questionKey === 'heard') <small>(Select one)</small>@endif</legend>
    @if($questionType === 'text')
        <div class="support-expectations-input"><textarea id="answer-expectations" name="expectations" maxlength="500" rows="6" data-counter aria-label="Your expectations (optional)" aria-describedby="count-expectations" placeholder="e.g. personalised support, trusted providers, better performance, emotional support, etc.">{{ old('expectations', data_get($assessment?->answers, 'expectations')) }}</textarea><output id="count-expectations" class="assessment-counter" for="answer-expectations">0/500</output></div>
    @else
        <div class="assessment-options {{ $questionType === 'radio' ? 'assessment-radios support-radio-options' : 'support-card-options' }}">
            @foreach($questionOptions as $option)
                <label class="assessment-option">
                    <input type="{{ $questionType === 'multi' ? 'checkbox' : 'radio' }}" name="{{ $questionKey }}{{ $questionType === 'multi' ? '[]' : '' }}" value="{{ $option }}" @checked(in_array($option, (array) old($questionKey, data_get($assessment?->answers, $questionKey, [])), true)) @required($questionType === 'radio')>
                    @if($questionKey === 'support')<i class="fa-solid fa-{{ ['book-open', 'user', 'bullseye', 'users', 'heart', 'people-group', 'compass', 'gear', 'ellipsis'][$loop->index] }}" aria-hidden="true"></i>@endif
                    <span>{{ $option }}@if($option === 'Other')<small>(Please specify)</small>@elseif($option === 'Career Guidance')<small>&amp; Future Readiness</small>@elseif($option === 'Life Skills')<small>(e.g. time management)</small>@endif</span>
                </label>
            @endforeach
        </div>
        @if(in_array('Other', $questionOptions, true))
            <div class="assessment-other" data-other-field @if(!in_array('Other', (array) old($questionKey, data_get($assessment?->answers, $questionKey, [])), true)) hidden @endif><label for="{{ $questionKey }}-other">Please specify</label><textarea id="{{ $questionKey }}-other" name="{{ $questionKey }}_other" maxlength="500" rows="2">{{ old($questionKey.'_other', data_get($assessment?->answers, $questionKey.'_other')) }}</textarea></div>
        @endif
        @if($questionKey === 'differences')<label class="needs-detail-label" for="answer-difference-details">If yes, please specify (Optional)</label><input class="needs-detail-input" id="answer-difference-details" name="difference_details" maxlength="500" value="{{ old('difference_details', data_get($assessment?->answers, 'difference_details')) }}" placeholder="e.g. dyslexia, ADHD, autism, etc.">@endif
    @endif
</fieldset>
