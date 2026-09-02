<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore VALYNK solutions for individuals, institutions, providers, foundations and corporations.">
    <title>Solutions | VALYNK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/solutions.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main id="top">
        <section class="solutions-hero">
            <div class="solutions-copy">
                <p class="eyebrow">Our solutions</p>
                <h1>Different Needs.<br>One Powerful Approach.</h1>
                <div class="rule"></div>
                <p>VALYNK offers a range of solutions designed to help individuals, institutions and organisations unlock potential, build capability and achieve lasting results.</p>
            </div>
            <div class="solutions-image" role="img" aria-label="Professionals collaborating around a laptop"></div>
        </section>

        <section class="solutions-cards">
            <article class="education">
                <i class="fa-solid fa-graduation-cap"></i>
                <h2>Learning &amp; Education</h2>
                <p>Academic support, tutoring, learning programs and skill development for all ages.</p>
                <a href="#">Explore <i class="fa-solid fa-arrow-right"></i></a>
            </article>
            <article class="development">
                <i class="fa-solid fa-brain"></i>
                <h2>Child Development</h2>
                <p>Cognitive, emotional and social development services to help children thrive.</p>
                <a href="#">Explore <i class="fa-solid fa-arrow-right"></i></a>
            </article>
            <article class="wellbeing">
                <i class="fa-solid fa-heart"></i>
                <h2>Health &amp; Wellbeing</h2>
                <p>Physical, mental and emotional wellbeing services for the whole family.</p>
                <a href="#">Explore <i class="fa-solid fa-arrow-right"></i></a>
            </article>
            <article class="care">
                <i class="fa-solid fa-briefcase"></i>
                <h2>Care &amp; Support</h2>
                <p>Trusted care, counselling and support services you can rely on.</p>
                <a href="#">Explore <i class="fa-solid fa-arrow-right"></i></a>
            </article>
            <article class="talent">
                <i class="fa-solid fa-star"></i>
                <h2>Enrichment &amp; Talent</h2>
                <p>Unlock potential through creativity, talent programs and life skills.</p>
                <a href="#">Explore <i class="fa-solid fa-arrow-right"></i></a>
            </article>
            <article class="organisation">
                <i class="fa-solid fa-building-columns"></i>
                <h2>Organisation Solutions</h2>
                <p>Professional services and solutions for schools, NGOs and institutions.</p>
                <a href="#">Explore <i class="fa-solid fa-arrow-right"></i></a>
            </article>
        </section>

        <section class="match-strip">
            <i class="fa-solid fa-diagram-project" aria-hidden="true"></i>
            <div>
                <h2>Need Something Specific?</h2>
                <p>Tell us what you need and we'll help you find the perfect match from our trusted network.</p>
            </div>
            <a class="button" href="#contact">Get Matched <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </section>

        <section class="value-band">
            <div class="value-heading">Value<br><span>You Can See</span></div>
            <article><i class="fa-solid fa-gauge-high"></i><strong>Higher<br>Performance</strong></article>
            <article><i class="fa-solid fa-lightbulb"></i><strong>Stronger<br>Leadership</strong></article>
            <article><i class="fa-solid fa-people-group"></i><strong>More Engaged<br>Teams</strong></article>
            <article><i class="fa-solid fa-chart-line"></i><strong>Lasting<br>Behaviour Change</strong></article>
            <article><i class="fa-solid fa-star"></i><strong>Greater<br>Social Impact</strong></article>
        </section>
    </main>
</main>
@include('partials.footer')
</body></html>