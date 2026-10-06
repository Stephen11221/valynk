<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | VALYNK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('css/get-connected.css') }}?v={{ filemtime(public_path('css/get-connected.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/assessment.css') }}?v={{ filemtime(public_path('css/assessment.css')) }}">
</head>
<body class="assessment-page focused-assessment-page reference-journey-page @yield('body-class')">
<a class="connection-skip" href="#journey-form">Skip to form</a>
@include('development.partials.journey-header')
<main class="focus-shell">
    <aside class="focus-story"><img src="{{ asset('images/about/family.png') }}" alt="A parent supporting her child"><div><h2>@if($activeStage === 2)Let’s<br>Get to Know<br><em>Your Child</em>@else Let’s<br>Understand<br><em>Better</em>@endif</h2><p>{{ $activeStage === 2 ? 'Please share a few details about your child so we can personalise the assessment and recommend the right support.' : 'A few simple questions (3–5 minutes) to understand your child’s current situation so we can recommend the most relevant support.' }}</p></div></aside>
    <section class="focus-content" aria-labelledby="journey-title">
        <ol class="focus-stepper" aria-label="Your progress">@foreach(['Sign Up & Quick Questions', 'Child’s Details', 'Full Assessment', 'Preview Report', 'Match & Programmes'] as $label)<li class="{{ $loop->iteration < $activeStage ? 'completed' : '' }}" @if($loop->iteration === $activeStage) aria-current="step" @endif><span>@if($loop->iteration < $activeStage)<i class="fa-solid fa-check" aria-hidden="true"></i>@else{{ $loop->iteration }}@endif</span><p>{{ $label }}</p></li>@endforeach</ol>
        <div class="focus-columns">
            <div class="focus-card">@if($errors->any())<div class="connection-errors" role="alert"><strong>Please check your answers.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif @yield('form')</div>
            <aside class="focus-panels" aria-label="Helpful information">
                <section class="focus-panel"><div class="focus-progress-heading"><h2>Your Progress</h2><span>@yield('progress-label')</span></div><progress value="@yield('progress-value')" max="@yield('progress-max')" aria-label="Your progress"></progress><p><i class="fa-regular fa-clock" aria-hidden="true"></i> @yield('progress-note', 'About 3–5 minutes to complete')</p></section>
                @hasSection('completion-panels')
                    @yield('completion-panels')
                @else
                @yield('help-panel')
                @if($activeStage === 3)<section class="focus-panel"><h2>Focus Areas for This Assessment</h2><p>We are asking questions in these areas to understand your child’s needs.</p><ul>@foreach(['Positive belief & winning mindset' => 'brain', 'Focus and discipline' => 'bullseye', 'Motivation and purpose' => 'flag'] as $label => $icon)<li><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>{{ $label }}</li>@endforeach</ul></section>@endif
                @if($activeStage === 2 || ($questionNumber ?? null) === 1)<section class="focus-panel focus-safe"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><div><h2>Your Information is Safe</h2><p>Your responses are private and only used to connect you with the right support, providers and programmes.</p></div></section>@endif
                @endif
            </aside>
        </div>
    </section>
</main>
</body>
</html>
