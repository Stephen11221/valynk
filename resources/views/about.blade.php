<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Learn about VALYNK and the evidence-backed connections we create.">
    <title>About VALYNK | The link that delivers</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about-spacing.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main>
        <section class="shell about-hero">
            <div class="about-copy">
                <p class="eyebrow">About VALYNK</p>
                <h1>The Link That Delivers</h1>
                <div class="rule"></div>
                <p>VALYNK was founded with a simple belief: every connection should create opportunity, drive impact, and deliver better outcomes.</p>
                <p>We saw too many families struggling to find the right support for their children, too many providers working in silos, and too many institutions lacking the tools to make confident, data-informed decisions. VALYNK was built to change that by connecting the right people, at the right time, with the right expertise.</p>
                <a class="button" href="#our-story">Our Story</a>
            </div>
            <div class="family-photo" role="img" aria-label="Family looking at a tablet together"></div>
        </section>

        <section class="shell story" id="our-story">
            <div class="story-copy">
                <div class="story-icon">◉</div>
                <h2>Our Story</h2>
                <p>VALYNK was created to solve a real and growing challenge: finding trusted support has become harder than it should be. What started as a vision to bring clarity to a fragmented ecosystem has grown into a platform that connects families, providers, and institutions through evidence, technology, and human expertise.</p>
                <p>Today, VALYNK is a trusted partner for thousands of families and organisations across multiple sectors. Our commitment remains the same: to build meaningful connections that empower children, strengthen communities, and shape a better future for all.</p>
            </div>
            <div class="story-image" role="img" aria-label="People helping each other on a mountain"></div>
        </section>

        <section class="shell purpose">
            <div class="purpose-block">
                <h2>Our Mission</h2>
                <div class="rule"></div>
                <p>To connect people and organisations with the right Providers and Institutions through evidence-backed matching, enabling better decisions and measurable outcomes.</p>
            </div>
            <div class="purpose-block">
                <h2>Our Vision</h2>
                <div class="rule"></div>
                <p>To be the most trusted global platform for meaningful connections that drive impact, transform lives and strengthen families and communities.</p>
            </div>
            <div class="values">
                <div class="value">
                    <div class="value-icon">✥</div>
                    <h3>Integrity</h3>
                    <p>We are honest, transparent and accountable in every interaction.</p>
                </div>
                <div class="value">
                    <div class="value-icon">⌕</div>
                    <h3>Evidence</h3>
                    <p>We rely on verified data and outcomes to drive better decisions.</p>
                </div>
                <div class="value">
                    <div class="value-icon">♧</div>
                    <h3>Impact</h3>
                    <p>We exist to create measurable, positive outcomes.</p>
                </div>
                <div class="value">
                    <div class="value-icon">⌁</div>
                    <h3>Partnership</h3>
                    <p>We believe in building lasting relationships based on trust.</p>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')</body></html>