<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Discover VALYNK's evidence-backed six-step matching process.">
    <title>How It Works | VALYNK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/how-it-works.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main id="top">
        <section class="how-hero">
            <div class="how-copy">
                <p class="eyebrow">How it works</p>
                <h1>Simple. Smart. Seamless.</h1>
                <div class="rule"></div>
                <p>VALYNK makes it easy to find the right support. Our evidence-backed matching process connects you with trusted experts and organisations so you can focus on what matters most.</p>
                <div class="promises">
                    <div class="promise"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><div><strong>Evidence-Backed</strong>Verified data and trusted practices</div></div>
                    <div class="promise"><i class="fa-solid fa-lock" aria-hidden="true"></i><div><strong>Safe &amp; Confidential</strong>Your privacy and data security are protected</div></div>
                    <div class="promise"><i class="fa-solid fa-people-group" aria-hidden="true"></i><div><strong>People-Centred</strong>Real people, real connections, real impact</div></div>
                    <div class="promise"><i class="fa-solid fa-bullseye" aria-hidden="true"></i><div><strong>Outcome-Focused</strong>We connect for impact that lasts</div></div>
                </div>
            </div>
            <div class="how-image" role="img" aria-label="Parent and child looking at a tablet"></div>
        </section>

        <section class="process-wrap">
            <h2>Our 6-Step Matching Process</h2>
            <div class="rule"></div>
            <div class="matching-steps">
                <article class="matching-step">
                    <div class="step-count">1</div>
                    <div class="step-icon"><i class="fa-solid fa-clipboard-list" aria-hidden="true"></i></div>
                    <h3>Tell Us Your Need</h3>
                    <p>Share your requirements and preferences in a few simple steps.</p>
                </article>
                <article class="matching-step">
                    <div class="step-count">2</div>
                    <div class="step-icon"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></div>
                    <h3>We Search &amp; Match</h3>
                    <p>Our intelligent system searches our verified network to find the best matches for you.</p>
                </article>
                <article class="matching-step">
                    <div class="step-count">3</div>
                    <div class="step-icon"><i class="fa-solid fa-people-group" aria-hidden="true"></i></div>
                    <h3>Review Matches</h3>
                    <p>Review curated matches with profiles, credentials, and evidence of impact.</p>
                </article>
                <article class="matching-step">
                    <div class="step-count">4</div>
                    <div class="step-icon"><i class="fa-solid fa-handshake" aria-hidden="true"></i></div>
                    <h3>Connect &amp; Engage</h3>
                    <p>Connect with your chosen provider or institution with confidence.</p>
                </article>
                <article class="matching-step">
                    <div class="step-count">5</div>
                    <div class="step-icon"><i class="fa-regular fa-comments" aria-hidden="true"></i></div>
                    <h3>Receive Support</h3>
                    <p>Receive the right support at the right time from trusted experts.</p>
                </article>
                <article class="matching-step">
                    <div class="step-count">6</div>
                    <div class="step-icon"><i class="fa-solid fa-chart-line" aria-hidden="true"></i></div>
                    <h3>Achieve Better Outcomes</h3>
                    <p>Track progress, measure impact, and create lasting positive change.</p>
                </article>
            </div>
        </section>

        <section class="why">
            <h2>Why It Works</h2>
            <article class="why-item">
                <div class="why-icon"><i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i></div>
                <div>
                    <strong>Smart Matching</strong>
                    <p>AI-powered matching with human expertise ensures better fit and outcomes.</p>
                </div>
            </article>
            <article class="why-item">
                <div class="why-icon"><i class="fa-solid fa-medal" aria-hidden="true"></i></div>
                <div>
                    <strong>Trusted Network</strong>
                    <p>All providers and institutions are verified, vetted, and continuously monitored.</p>
                </div>
            </article>
            <article class="why-item">
                <div class="why-icon"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></div>
                <div>
                    <strong>End-to-End Support</strong>
                    <p>From discovery to delivery, we're with you every step of the way.</p>
                </div>
            </article>
            <article class="why-item">
                <div class="why-icon"><i class="fa-solid fa-chart-line" aria-hidden="true"></i></div>
                <div>
                    <strong>Measurable Impact</strong>
                    <p>We focus on outcomes that matter and help you track what makes a difference.</p>
                </div>
            </article>
        </section>
</main>
@include('partials.footer')
</body>
</html>
