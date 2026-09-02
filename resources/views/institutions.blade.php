<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Build stronger partnerships and better outcomes with VALYNK.">
    <title>For Institutions | VALYNK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/institutions.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main id="top">
        <section class="institution-layout">
            <div class="institution-main">
                <p class="eyebrow">For institutions</p>
                <h1>Stronger Partnerships. Better Outcomes.</h1>
                <div class="rule"></div>
                <p class="institution-intro">VALYNK connects you with verified experts and providers who help you deliver high-impact support to the children, students and communities you serve.</p>
                <div class="institution-benefits">
                    <article><i class="fa-solid fa-people-group"></i><h3>Trusted Network</h3><p>Access a curated network of verified Providers and specialists.</p></article>
                    <article><i class="fa-solid fa-handshake"></i><h3>Quality Assurance</h3><p>Every Provider is vetted for expertise, credibility and reliability.</p></article>
                    <article><i class="fa-solid fa-chart-line"></i><h3>Better Outcomes</h3><p>Connect your beneficiaries with the right support for measurable results.</p></article>
                    <article><i class="fa-solid fa-shield-halved"></i><h3>Risk &amp; Compliance</h3><p>We help you work with trusted professionals that meet your standards.</p></article>
                    <article><i class="fa-solid fa-diagram-project"></i><h3>Ongoing Support</h3><p>We partner with you every step, before, during and after engagement.</p></article>
                </div>
            </div>
            <aside class="institution-aside">
                <div class="institution-photo" role="img" aria-label="Institution partners collaborating at a laptop"></div>
                <div class="partner-card">
                    <h2>Partner With Us</h2>
                    <p>Create your Institution profile and start connecting with verified Providers who can help you achieve your mission.</p>
                    <a class="button" href="#partner">Join as an Institution <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </aside>
        </section>

        <section class="institution-values">
            <div class="institution-value-title">
                <i class="fa-solid fa-award"></i>
                <h2>We value<br>Institutions who:</h2>
            </div>
            <article>
                <i class="fa-regular fa-circle-check"></i>
                <div>
                    <strong>Deliver Impact</strong>
                    <p>You are committed to improving lives and creating measurable change.</p>
                </div>
            </article>
            <article>
                <i class="fa-regular fa-circle-check"></i>
                <div>
                    <strong>Uphold Integrity</strong>
                    <p>You operate with transparency, accountability and ethical standards.</p>
                </div>
            </article>
            <article>
                <i class="fa-regular fa-circle-check"></i>
                <div>
                    <strong>Value Collaboration</strong>
                    <p>You believe in the power of partnerships and shared success.</p>
                </div>
            </article>
            <article>
                <i class="fa-regular fa-circle-check"></i>
                <div>
                    <strong>Focus on People</strong>
                    <p>You put children, students and communities at the center of your work.</p>
                </div>
            </article>
            <article>
                <i class="fa-regular fa-circle-check"></i>
                <div>
                    <strong>Keep Improving</strong>
                    <p>You embrace learning, evidence and continuous improvement.</p>
                </div>
            </article>
        </section>

        <section class="serve-section">
            <h2>Who We Serve</h2>
            <div class="rule"></div>
            <div class="serve-grid">
                <article>
                    <i class="fa-solid fa-graduation-cap"></i>
                    <div>
                        <h3>Educational Institutions</h3>
                        <p>Schools, colleges and universities seeking expert support and programs.</p>
                    </div>
                </article>
                <article>
                    <i class="fa-solid fa-people-group"></i>
                    <div>
                        <h3>Community Organisations</h3>
                        <p>NGOs and CBOs driving impact in their communities and beyond.</p>
                    </div>
                </article>
                <article>
                    <i class="fa-solid fa-people-roof"></i>
                    <div>
                        <h3>Families &amp; Individuals</h3>
                        <p>Parents and individuals looking for trusted experts and guidance.</p>
                    </div>
                </article>
                <article>
                    <i class="fa-solid fa-building-columns"></i>
                    <div>
                        <h3>Government &amp; Public Sector</h3>
                        <p>Departments and agencies seeking partners for public impact initiatives.</p>
                    </div>
                </article>
                <article>
                    <i class="fa-solid fa-building"></i>
                    <div>
                        <h3>Private Sector &amp; Funders</h3>
                        <p>Companies and foundations investing in people and community development.</p>
                    </div>
                </article>
            </div>
        </section>
    </main>
@include('partials.footer')
</body></html>