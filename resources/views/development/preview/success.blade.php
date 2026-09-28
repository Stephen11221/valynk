@php($step = 5)
@php($journeyStage = 4)
@php($plansPage = true)
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Successful — Preview | VALYNK</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('css/get-connected.css') }}?v={{ filemtime(public_path('css/get-connected.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/assessment.css') }}?v={{ filemtime(public_path('css/assessment.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/payment-success.css') }}?v={{ filemtime(public_path('css/payment-success.css')) }}">
</head>
<body class="assessment-page assessment-support-page payment-success-page">
<a class="connection-skip" href="#success-content">Skip to report options</a>
<main class="connection-shell assessment-shell">
    <a class="connection-close" href="{{ route('solutions') }}" aria-label="Close and return to solutions"><i class="fa-solid fa-xmark" aria-hidden="true"></i></a>
    <aside class="connection-story assessment-story">
        <a class="connection-brand" href="{{ route('home') }}"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK — Connect, Empower, Transform"></a>
        <div class="connection-story-copy">
            @if(!in_array($step, [3, 4, 5], true))
            <h2><span>Welcome,</span> <br>Let’s Find the Right Support for Your Child.</h2>
            <p class="assessment-story-intro">A few quick questions will help us understand your child’s needs and match you with suitable support and providers.</p>
            @endif
            <ol class="assessment-side-steps">
                @foreach([['Account Created', 'Welcome to VALYNK'], ['Take Assessment', 'Help us understand your child'], ['View Report & Match', 'Review your support summary'], ['Connect', 'Choose support for your child']] as [$title, $description])
                    <li @if($loop->iteration === $journeyStage) aria-current="step" @endif><span class="assessment-side-number">{{ $loop->iteration }}</span><div><h3>{{ $title }} @if($loop->iteration < $journeyStage)<i class="fa-solid fa-circle-check" aria-label="Completed"></i>@endif</h3><p>{{ $description }}</p></div></li>
                @endforeach
            </ol>
            <p class="connection-tagline">@if($step === 5 && !$plansPage)“Support today. A <em>brighter</em> tomorrow.”@else A Brighter<br>Tomorrow<br>Together @endif</p>
        </div>
        <img class="connection-portrait" src="{{ asset('images/solutions/confidence-hero.png') }}" alt="A student looking ahead with confidence">
        @if(in_array($step, [3, 4, 5], true))<div class="assessment-story-values"><span><i class="fa-solid fa-people-group" aria-hidden="true"></i>People<br>First</span><span><i class="fa-solid fa-shield-halved" aria-hidden="true"></i>Trusted<br>Connections</span><span><i class="fa-solid fa-lightbulb" aria-hidden="true"></i>Brighter<br>Futures</span></div>@endif
    </aside>

    <section class="assessment-content" id="success-content" aria-labelledby="success-title">
        <header class="assessment-heading connection-heading">
            <div><p class="success-eyebrow">Step 4 of 4 · Sample journey</p><h1 id="success-title">Payment Successful!</h1><h2>Your child’s personalised report is ready.</h2><p>A preview of the experience after a verified payment. Explore the sample report and support options below.</p></div>
            <ol class="connection-stepper" aria-label="Sample journey progress">@foreach(['Create Account', 'Take Assessment', 'View Report & Match', 'Pay & Connect'] as $label)<li class="completed" @if($loop->last) aria-current="step" @endif><span>@if($loop->last)4 @else<i class="fa-solid fa-check" aria-hidden="true"></i>@endif</span><p>{{ $label }}</p></li>@endforeach</ol>
        </header>
        <section class="success-confirmation" aria-label="Preview status"><i class="fa-solid fa-check" aria-hidden="true"></i><div><h2>Payment confirmation preview</h2><p>No payment has been processed and no receipt has been emailed.</p></div><span>Demonstration only<br>Sample report</span></section>
        <div class="success-report-grid">
            <section class="success-download"><header class="success-card-title"><i class="fa-regular fa-file-lines" aria-hidden="true"></i><div><h2>Your Full Report is Ready</h2><p>Explore a sample report with strengths, growth areas and recommended support.</p></div></header><a class="success-primary" href="{{ route('development.sample.pdf') }}"><i class="fa-solid fa-download" aria-hidden="true"></i> Download Sample Report (PDF)</a><div class="success-download-options"><a href="{{ route('development.sample') }}"><i class="fa-solid fa-eye" aria-hidden="true"></i> View Report Online</a><button type="button" disabled aria-describedby="email-unavailable"><i class="fa-regular fa-envelope" aria-hidden="true"></i> Email Me a Copy</button></div><p class="success-email-note" id="email-unavailable">Email delivery is not available in this preview.</p></section>
            <section class="success-samples"><header><h2>Sample Pages from Your Report</h2><a href="{{ route('development.sample') }}">View Full Report →</a></header><div class="success-page-previews">
                <a class="success-cover" href="{{ route('development.sample.pdf') }}" aria-label="Open sample report PDF"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK"><h3>Child<br>Development<br>Insights</h3><p>A Brighter<br>Tomorrow.<br>Together.</p><span>Sample report</span></a>
                <article class="success-mini-page"><h3>Key Strengths</h3>@foreach(['Curiosity & Learning', 'Creativity', 'Social Skills', 'Learning Attitude'] as $strength)<p><span class="success-mini-bar" aria-hidden="true"></span>{{ $strength }}</p>@endforeach<small>Illustrative examples</small></article>
                <article class="success-mini-page"><h3>Recommended Support</h3>@foreach(['Mindset Coaching', 'Study Skills Development', 'Emotional Wellbeing', 'Enrichment Activities'] as $support)<p><i class="fa-regular fa-heart" aria-hidden="true"></i>{{ $support }}</p>@endforeach<small>Illustrative examples</small></article>
            </div></section>
        </div>
        <div class="success-bottom-grid"><section class="success-next"><header class="success-card-title"><i class="fa-solid fa-compass" aria-hidden="true"></i><h2>What Happens Next?</h2></header><ol>@foreach([['people-group', 'Explore Providers', 'Review verified providers and the support they offer.'], ['list-check', 'You Choose', 'Compare services and choose support relevant to your child.'], ['handshake', 'Start the Journey', 'Send a connection request and discuss availability with your provider.']] as [$icon, $title, $description])<li><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><h3>{{ $title }}</h3><p>{{ $description }}</p></li>@endforeach</ol></section><aside class="success-help"><header class="success-card-title"><i class="fa-regular fa-comment-dots" aria-hidden="true"></i><div><h2>Need Help?</h2><p>Our team is here to support you.</p></div></header><p>For questions about reports, plans or connecting with providers, visit our support page.</p><a href="{{ route('contact') }}">Contact our team →</a></aside></div>
        <footer class="success-actions"><a class="success-dashboard" href="{{ route('development.home') }}"><i class="fa-solid fa-house" aria-hidden="true"></i> Back to Dashboard</a><a class="success-primary" href="{{ route('development.providers') }}">Find and Connect with Providers <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a><p>More Possibilities.<br>Brighter Futures.</p></footer>
    </section>
</main>
</body>
</html>
