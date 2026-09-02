<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grow your practice and impact with VALYNK.">
    <title>For Providers | VALYNK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/providers.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main id="top">
        <section class="provider-layout">
            <div class="provider-main">
                <p class="eyebrow">For providers</p>
                <h1>Grow Your Impact. Expand Your Reach.</h1>
                <div class="rule"></div>
                <p class="provider-intro">VALYNK connects you with the right people and organisations that need your expertise. Join a trusted network of verified Providers and grow your impact.</p>
                <div class="provider-benefits">
                    <article><i class="fa-solid fa-people-group"></i><h3>Increase Visibility</h3><p>Get discovered by Institutions and individuals looking for your services.</p></article>
                    <article><i class="fa-solid fa-handshake"></i><h3>Quality Connections</h3><p>We match you with the right opportunities based on verified evidence.</p></article>
                    <article><i class="fa-solid fa-chart-line"></i><h3>Grow Your Impact</h3><p>Help more people and organisations achieve measurable outcomes.</p></article>
                    <article><i class="fa-solid fa-shield-halved"></i><h3>Build Trust</h3><p>Our verification process builds credibility and confidence.</p></article>
                    <article><i class="fa-solid fa-diagram-project"></i><h3>Ongoing Support</h3><p>We're with you every step, before, during and after the match.</p></article>
                </div>
            </div>
            <aside class="provider-aside">
                <div class="provider-photo" role="img" aria-label="Professional providers collaborating at a laptop"></div>
                <div class="join-card">
                    <h2>Ready to Join?</h2>
                    <p>Create your Provider profile and start connecting with opportunities that match your expertise.</p>
                    <a class="button" href="#join">Join as a Provider <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </aside>
        </section>

        <section class="provider-values">
            <div class="value-title">
                <i class="fa-solid fa-award"></i>
                <h2>We value<br>Providers who:</h2>
            </div>
            <article>
                <i class="fa-regular fa-circle-check"></i>
                <div>
                    <strong>Deliver Results</strong>
                    <p>You are committed to measurable outcomes and real impact.</p>
                </div>
            </article>
            <article>
                <i class="fa-regular fa-circle-check"></i>
                <div>
                    <strong>Uphold Integrity</strong>
                    <p>You operate with honesty, professionalism and transparency.</p>
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
                    <p>You put people and communities at the center of your work.</p>
                </div>
            </article>
            <article>
                <i class="fa-regular fa-circle-check"></i>
                <div>
                    <strong>Keep Improving</strong>
                    <p>You embrace evidence, learning and continuous improvement.</p>
                </div>
            </article>
        </section>

        <section class="provider-process">
            <h2>How VALYNK Works for Providers</h2>
            <div class="rule"></div>
            <div class="provider-steps">
                <article>
                    <i class="fa-solid fa-user-plus"></i>
                    <h3>1. Register</h3>
                    <p>Create your provider profile and tell us about your expertise.</p>
                </article>
                <article>
                    <i class="fa-solid fa-clipboard-check"></i>
                    <h3>2. Get Matched</h3>
                    <p>We match you with relevant opportunities based on your skills and preferences.</p>
                </article>
                <article>
                    <i class="fa-solid fa-handshake"></i>
                    <h3>3. Connect</h3>
                    <p>Review opportunities and connect with families or institutions.</p>
                </article>
                <article>
                    <i class="fa-solid fa-calendar-days active-step"></i>
                    <h3>4. Deliver</h3>
                    <p>Provide your expert support and help create meaningful outcomes.</p>
                </article>
                <article>
                    <i class="fa-solid fa-chart-line active-step"></i>
                    <h3>5. Grow</h3>
                    <p>Track your impact, build your reputation and grow your practice.</p>
                </article>
            </div>
        </section>
    </main>
@include('partials.footer')
</body></html>