<div class="assessment-needs">
    @foreach([['learning', 'differences'], ['disability', 'emotional'], ['social', 'notes']] as $row)
        <div class="assessment-needs-row">
            @foreach($row as $key)
                @php
                    [$label, $type, $options] = config('development.questions.2.'.$key);
                    $number = ['learning' => 4, 'differences' => 5, 'disability' => 6, 'emotional' => 7, 'social' => 8, 'notes' => 9][$key];
                @endphp
                <fieldset class="assessment-question needs-question needs-{{ $key }}" data-question="{{ $key }}">
                    <legend><span>{{ $number }}.</span> {{ $label }}</legend>
                    @if($key === 'learning')
                        <p class="assessment-hint">Select all that apply.</p>
                        <div class="assessment-options learning-options">
                            @foreach($options as $option)
                                <label class="assessment-option">
                                    <input type="checkbox" name="learning[]" value="{{ $option }}" @checked(in_array($option, (array) old('learning', data_get($assessment?->answers, 'learning', [])), true))>
                                    <i class="fa-solid fa-{{ ['eye', 'headphones', 'hand', 'book-open', 'diagram-project', 'circle-question'][$loop->index] }}" aria-hidden="true"></i>
                                    <span>{{ $option }}@if($loop->index < 3)<small>({{ ['seeing', 'listening', 'doing'][$loop->index] }})</small>@endif</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($type === 'radio')
                        <div class="assessment-options assessment-radios needs-radios">
                            @foreach($options as $option)
                                <label class="assessment-option"><input type="radio" name="{{ $key }}" value="{{ $option }}" required @checked(old($key, data_get($assessment?->answers, $key)) === $option)><span>{{ $option }}</span></label>
                            @endforeach
                        </div>
                        @if(in_array($key, ['differences', 'disability'], true))
                            @php($detailKey = $key === 'differences' ? 'difference_details' : 'disability_details')
                            <label class="needs-detail-label" for="answer-{{ $detailKey }}">If yes, please specify <span>(Optional)</span></label>
                            <input class="needs-detail-input" id="answer-{{ $detailKey }}" name="{{ $detailKey }}" maxlength="500" value="{{ old($detailKey, data_get($assessment?->answers, $detailKey)) }}" placeholder="{{ $key === 'differences' ? 'e.g. dyslexia, ADHD, autism, etc.' : 'e.g. physical, visual, hearing, intellectual, neurological, etc.' }}">
                        @endif
                    @else
                        <div class="needs-notes"><textarea id="answer-notes" name="notes" maxlength="500" rows="4" data-counter aria-label="Additional information (optional)" aria-describedby="count-notes" placeholder="e.g. interests, challenges, medical conditions, preferences, goals, etc.">{{ old('notes', data_get($assessment?->answers, 'notes')) }}</textarea><output id="count-notes" class="assessment-counter" for="answer-notes">0/500</output></div>
                    @endif
                </fieldset>
            @endforeach
        </div>
    @endforeach
</div>
