@php
    $answers = $assessment->answers ?? [];
    $summaryItems = [
        ['user', 'Child’s Name', $child->name],
        ['calendar-days', 'Age', $child->age.' years'],
        ['graduation-cap', 'Education Level', data_get($answers, 'education', $child->grade)],
        ['school', 'Learning Environment', data_get($answers, 'environment', 'Not provided')],
        ['table-cells-large', 'Support Areas', implode(', ', (array) data_get($answers, 'support', [])) ?: 'Not provided'],
        ['heart', 'Additional Needs', implode(', ', (array) data_get($answers, 'health', [])) ?: 'Not provided'],
        ['comment-dots', 'How You Heard About VALYNK', data_get($answers, 'heard', 'Not provided')],
    ];
@endphp
<div class="review-layout">
    <div class="review-main">
        <section class="review-card" aria-labelledby="review-title">
            <header class="review-card-heading"><i class="fa-regular fa-file-lines" aria-hidden="true"></i><div><h2 id="review-title">Summary of Your Child’s Information</h2><p>Please review the details below. You can go back to edit if needed.</p></div><a href="{{ route('development.assessment', [$child, 4]) }}" class="review-edit"><i class="fa-regular fa-pen-to-square" aria-hidden="true"></i> Edit</a></header>
            <dl class="review-summary">
                @foreach(config('development.mindset_questions') as $question)
                    @if(data_get($answers, 'personal_development.'.$question['key']))<div><i class="fa-solid fa-{{ $question['icon'] }}" aria-hidden="true"></i><div><dt>{{ $question['label'] }}</dt><dd>{{ data_get($answers, 'personal_development.'.$question['key']) }}</dd></div></div>@endif
                @endforeach
                @foreach($summaryItems as [$icon, $label, $value])
                    <div><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div></div>
                @endforeach
            </dl>
            <details class="review-all-answers"><summary>Review all answers &amp; edit</summary>
                @if($child->support_notes)<p><strong>About your child:</strong> {{ $child->support_notes }}</p>@endif
                @foreach(config('development.questions') as $part => $questions)
                    <section><h3>Assessment part {{ $part }} <a href="{{ route('development.assessment', [$child, $part]) }}">Edit<span class="review-sr-only"> assessment part {{ $part }}</span> →</a></h3><dl>@foreach($questions as $key => [$label, $type, $options])<div><dt>{{ $label }}</dt><dd>{{ implode(', ', (array) data_get($answers, $key, [])) ?: 'Not provided' }}@if(data_get($answers, $key.'_other'))<p>{{ data_get($answers, $key.'_other') }}</p>@endif</dd></div>@endforeach</dl></section>
                @endforeach
            </details>
        </section>
        <aside class="review-callout review-almost"><i class="fa-solid fa-info" aria-hidden="true"></i><div><h2>You’re almost there!</h2><p>Once you proceed, you can review your personalised support summary and explore trusted providers.</p></div></aside>
    </div>
    <div class="review-aside">
        <section class="review-card review-consent-card" aria-labelledby="consent-title">
            <header class="review-card-heading"><i class="fa-solid fa-user" aria-hidden="true"></i><div><h2 id="consent-title">Parental Consent</h2><p>Please confirm the following:</p></div></header>
            <fieldset class="review-consent"><legend class="review-sr-only">Confirm your consent to continue</legend>
                @foreach(['guardian' => 'I am the parent or legal guardian, or an adult completing my own profile.', 'consent' => 'I consent to VALYNK storing these answers and generating a summary of the support needs I have described.', 'sharing' => 'I understand that sharing with a provider requires a separate connection request.'] as $key => $label)
                    <label><input type="checkbox" name="{{ $key }}" value="1" required @checked(old($key))><span>{{ $label }}</span></label>
                @endforeach
            </fieldset>
            <details class="review-privacy"><summary><i class="fa-regular fa-file-lines" aria-hidden="true"></i> How we use your information</summary><p>Your account stores your child’s profile and assessment answers. Sharing with a provider requires separate confirmation. <a href="{{ route('contact') }}">Contact our team</a> to request changes or deletion.</p></details>
        </section>
        <aside class="review-callout review-safe"><i class="fa-solid fa-lock" aria-hidden="true"></i><div><h2>Your Information is Safe</h2><p>Your assessment answers are stored encrypted. Only you can access your child’s assessment through your account. Your report summarises your observations; it is not a clinical assessment.</p></div></aside>
    </div>
</div>
