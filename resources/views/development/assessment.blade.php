<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $step === 5 ? 'Review & Consent' : 'Take a Brief Assessment' }} | VALYNK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('css/get-connected.css') }}?v={{ filemtime(public_path('css/get-connected.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/assessment.css') }}?v={{ filemtime(public_path('css/assessment.css')) }}">
    <script src="{{ asset('js/assessment.js') }}?v={{ filemtime(public_path('js/assessment.js')) }}" defer></script>
</head>
<body class="assessment-page {{ $step === 2 ? 'assessment-needs-page' : '' }}">
<a class="connection-skip" href="#assessment-form">Skip to assessment</a>
<main class="connection-shell assessment-shell">
    <a class="connection-close" href="{{ route('development.home') }}" aria-label="Close and return to your dashboard"><i class="fa-solid fa-xmark" aria-hidden="true"></i></a>
    <aside class="connection-story assessment-story">
        <a class="connection-brand" href="{{ route('home') }}"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK — Connect, Empower, Transform"></a>
        <div class="connection-story-copy">
            <h2><span>Welcome,</span> <br>Let’s Find the Right Support for Your Child.</h2>
            <p class="assessment-story-intro">A few quick questions will help us understand your child’s needs and match you with suitable support and providers.</p>
            <ol class="assessment-side-steps">
                @foreach([['Account Created', 'Welcome to VALYNK'], ['Take Assessment', 'Help us understand your child'], ['View Report & Match', 'Review your support summary'], ['Connect', 'Choose support for your child']] as [$title, $description])
                    <li @if($loop->iteration === 2) aria-current="step" @endif><span class="assessment-side-number">{{ $loop->iteration }}</span><div><h3>{{ $title }} @if($loop->first)<i class="fa-solid fa-circle-check" aria-label="Completed"></i>@endif</h3><p>{{ $description }}</p></div></li>
                @endforeach
            </ol>
            <p class="connection-tagline">A Brighter<br>Tomorrow<br>Together</p>
        </div>
        <img class="connection-portrait" src="{{ asset('images/solutions/confidence-hero.png') }}" alt="A student looking ahead with confidence">
    </aside>

    <section class="assessment-content" aria-labelledby="assessment-title">
        <header class="connection-heading assessment-heading">
            <div><h1 id="assessment-title"><span>Step 2:</span> {{ $step === 5 ? 'Review Your Assessment' : 'Take a Brief Assessment' }}</h1><p>Let’s understand your child better so we can find relevant support.</p></div>
            <ol class="connection-stepper" aria-label="Your progress">@foreach(['Create Account', 'Take Assessment', 'View Report & Match', 'Connect'] as $label)<li class="{{ $loop->first ? 'completed' : '' }}" @if($loop->iteration === 2) aria-current="step" @endif><span>@if($loop->first)<i class="fa-solid fa-check" aria-hidden="true"></i>@else{{ $loop->iteration }}@endif</span><p>{{ $label }}</p></li>@endforeach</ol>
        </header>
        <div class="assessment-notice"><i class="fa-solid fa-{{ $step === 2 ? 'people-group' : 'clipboard-list' }}" aria-hidden="true"></i><div><h2>{{ $step === 5 ? 'Please review your answers before continuing.' : ($step === 2 ? 'Every child is unique.' : 'A few questions. A clearer picture of your child’s needs.') }}</h2><p>{{ $step === 2 ? 'Your responses help us understand their learning, emotional and social needs so we can match you with the right support.' : 'Your responses are confidential. Your progress is saved when you select Next.' }}</p></div></div>
        <p class="assessment-child-line"><strong>{{ $child->name }}</strong> · Age {{ $child->age }} · {{ $child->grade }} <span>{{ $step === 5 ? 'Review & consent' : 'Part '.$step.' of 4' }}</span></p>

        <form id="assessment-form" method="POST" action="{{ route('development.assessment.save', [$child, $step]) }}">
            @csrf
            @if($errors->any())<div class="connection-errors" role="alert" tabindex="-1"><strong>Please check your answers.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @if($step === 2)
                @include('development.assessment-needs')
            @elseif($step < 5)
                @foreach(config('development.questions.'.$step) as $key => [$label, $type, $options])
                    <fieldset class="assessment-question" data-question="{{ $key }}" @if($type === 'goals') data-max="3" @endif>
                        <legend><span>{{ $loop->iteration }}.</span> {{ $label }}</legend>
                        @if($type === 'text')
                            <label class="assessment-text-label" for="answer-{{ $key }}">Your response (optional)</label>
                            <textarea id="answer-{{ $key }}" name="{{ $key }}" maxlength="500" rows="3" data-counter aria-describedby="count-{{ $key }}">{{ old($key, data_get($assessment?->answers, $key)) }}</textarea><output id="count-{{ $key }}" class="assessment-counter" for="answer-{{ $key }}">0/500</output>
                        @else
                            <p class="assessment-hint">{{ $type === 'goals' ? 'Select up to 3.' : ($type === 'multi' ? 'Select all that apply.' : 'Select one.') }}</p>
                            <div class="assessment-options {{ $type === 'radio' ? 'assessment-radios' : '' }}">
                                @foreach($options as $option)
                                    <label class="assessment-option">
                                        <input type="{{ in_array($type, ['multi', 'goals']) ? 'checkbox' : 'radio' }}" name="{{ $key }}{{ in_array($type, ['multi', 'goals']) ? '[]' : '' }}" value="{{ $option }}" @checked(in_array($option, (array) old($key, data_get($assessment?->answers, $key, [])), true)) @required($type === 'radio')>
                                        @if($type !== 'radio')<i class="fa-solid fa-{{ config('development.assessment_icons.'.$key.'.'.$loop->index, 'circle-check') }}" aria-hidden="true"></i>@endif
                                        <span>{{ $option }}@if($option === 'Other')<small>(Please specify)</small>@endif</span>
                                    </label>
                                @endforeach
                            </div>
                            @if($type === 'goals')<p class="assessment-selection-count" role="status" data-selection-count></p>@endif
                            @if(in_array('Other', $options, true))
                                <div class="assessment-other" data-other-field @if(!in_array('Other', (array) old($key, data_get($assessment?->answers, $key, [])), true)) hidden @endif>
                                    <label for="{{ $key }}-other">Please specify your other {{ $key === 'goals' ? 'goal' : 'response' }}</label>
                                    <textarea id="{{ $key }}-other" name="{{ $key }}_other" maxlength="500" rows="2">{{ old($key.'_other', data_get($assessment?->answers, $key.'_other')) }}</textarea>
                                </div>
                            @endif
                        @endif
                    </fieldset>
                @endforeach
            @else
                <section class="assessment-review" aria-labelledby="review-title"><h2 id="review-title">Summary of Your Child’s Information</h2><p>{{ $child->name }} · {{ $child->age }} years · {{ $child->grade }}@if($child->school) · {{ $child->school }}@endif</p>
                    @if($child->support_notes)<p><strong>About your child:</strong> {{ $child->support_notes }}</p>@endif
                    @foreach(config('development.questions') as $part => $questions)
                        <details @if($loop->first) open @endif><summary>Assessment part {{ $part }}</summary><a class="assessment-edit" href="{{ route('development.assessment', [$child, $part]) }}">Edit these answers →</a><dl>@foreach($questions as $key => [$label, $type, $options])<div><dt>{{ $label }}</dt><dd>{{ implode(', ', (array) data_get($assessment->answers, $key, [])) ?: 'Not provided' }}@if(data_get($assessment->answers, $key.'_other'))<p>{{ data_get($assessment->answers, $key.'_other') }}</p>@endif</dd></div>@endforeach</dl></details>
                    @endforeach
                </section>
                <fieldset class="assessment-consent"><legend>Parental Consent</legend>@foreach(['guardian' => 'I am the parent or legal guardian, or an adult completing my own profile.', 'consent' => 'I consent to VALYNK storing these answers and generating a summary of the support needs I have described.', 'sharing' => 'I understand that sharing with a provider requires a separate connection request.'] as $key => $label)<label><input type="checkbox" name="{{ $key }}" value="1" required @checked(old($key))><span>{{ $label }}</span></label>@endforeach<p>Your report summarises your observations; it is not a clinical assessment.</p></fieldset>
            @endif
            <div class="assessment-actions"><a class="assessment-back" href="{{ $step > 1 ? route('development.assessment', [$child, $step - 1]) : route('development.home') }}"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back</a><button class="connection-submit" type="submit">{{ $step === 5 ? 'View My Summary' : 'Next' }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button><a class="assessment-help" href="{{ route('contact') }}"><strong>Need Help?</strong><i class="fa-regular fa-comment-dots" aria-hidden="true"></i><span>Contact us</span></a></div>
        </form>
    </section>
</main>
</body>
</html>
