<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ data_get($page, 'meta_description', 'Learn about VALYNK and the evidence-backed connections we create.') }}">
    <title>{{ data_get($page, 'title', 'About VALYNK | The link that delivers') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>
<body class="about-page">
    @include('partials.navbar')

    <main class="about-main">
        <section class="about-wrap about-hero" aria-labelledby="about-title">
            <div class="about-copy">
                <p class="about-eyebrow">{{ data_get($page, 'content.eyebrow', 'About VALYNK') }}</p>
                <h1 id="about-title">{{ data_get($page, 'content.heading', 'The Link That Delivers') }}</h1>
                <span class="about-rule" aria-hidden="true"></span>
                <p>{{ data_get($page, 'content.intro', 'VALYNK was founded with a simple belief: every connection should create opportunity, drive impact, and deliver better outcomes.') }}</p>
                <p>We saw too many families struggling to find the right support for their children, too many providers working in silos, and too many institutions lacking the tools to make confident, data-informed decisions. VALYNK was built to change that by connecting the right people, at the right time, with the right expertise.</p>
                <a class="about-button" href="#our-story">Our Story</a>
            </div>
            <img class="about-family" src="{{ asset('images/about/family.png') }}" alt="A family sharing a tablet together at home" width="1536" height="640" fetchpriority="high">
        </section>
        <section class="about-wrap about-story" id="our-story" aria-labelledby="story-title">
            <div class="about-story-copy">
                <span class="about-circle" aria-hidden="true"><i class="fa-solid fa-book-open"></i></span>
                <div><h2 id="story-title">Our Story</h2><span class="about-rule" aria-hidden="true"></span>
                    <p>VALYNK was created to solve a real and growing challenge—finding trusted support that truly meets each child’s needs. What started as a vision to bring clarity to a fragmented ecosystem has grown into a platform that connects families, providers, and institutions through evidence, technology, and human expertise.</p>
                    <p>Our commitment remains the same: to build meaningful connections that empower children, strengthen communities, and shape a better future for all.</p>
                </div>
            </div>
            <img class="about-team" src="{{ asset('images/about/teamwork.png') }}" alt="Hikers helping one another reach a mountain summit at sunset" width="1536" height="640" loading="lazy">
        </section>
        <section class="about-wrap about-purpose" aria-label="Our mission, vision and values">
            <article class="about-purpose-card"><span class="about-circle" aria-hidden="true"><i class="fa-solid fa-bullseye"></i></span><div><h2>Our Mission</h2><span class="about-rule" aria-hidden="true"></span><p>To connect people and organisations with the right Providers and Institutions through evidence-backed matching, enabling better decisions and measurable outcomes.</p></div></article>
            <article class="about-purpose-card"><span class="about-circle" aria-hidden="true"><i class="fa-regular fa-eye"></i></span><div><h2>Our Vision</h2><span class="about-rule" aria-hidden="true"></span><p>To be the most trusted global platform for meaningful connections that drive impact, transform lives and strengthen communities.</p></div></article>
            <div class="about-values"><h2>Our Values</h2><span class="about-rule" aria-hidden="true"></span><div class="about-values-grid">
                <article><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><h3>Integrity</h3><p>We are honest, transparent and accountable in every interaction.</p></article>
                <article><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><h3>Evidence</h3><p>We rely on verified data and outcomes to drive better decisions.</p></article>
                <article><i class="fa-solid fa-people-group" aria-hidden="true"></i><h3>Impact</h3><p>We exist to create measurable, positive outcomes.</p></article>
                <article><i class="fa-regular fa-handshake" aria-hidden="true"></i><h3>Partnership</h3><p>We believe in building lasting relationships built on trust.</p></article>
                <article><i class="fa-regular fa-lightbulb" aria-hidden="true"></i><h3>Innovation</h3><p>We continuously improve to deliver smarter connections.</p></article>
            </div></div>
        </section>
    </main>

    @include('partials.footer')</body></html>
