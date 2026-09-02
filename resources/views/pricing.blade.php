<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Simple, transparent VALYNK pricing for individuals, families, providers, and institutions."><title>Pricing | VALYNK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}"><link rel="stylesheet" href="{{ asset('css/pricing.css') }}">
</head>
<body>
@include('partials.navbar')
<main id="top">

        <section class="pricing-layout">
            <div class="pricing-main">
                <p class="eyebrow">Pricing</p>
                <h1>Simple, Transparent Pricing.<br>Real Value.</h1>
                <div class="rule"></div>
                <p class="pricing-intro">Choose the plan that fits your needs. Whether you're an individual, a family, a Provider or an Institution, there's a VALYNK plan for you.</p>

                <div class="price-grid">
                    <article>
                        <div class="price-title">
                            <i class="fa-solid fa-user"></i>
                            <div>
                                <h3>For Individuals</h3>
                                <p>Access expert support and resources for your personal growth and success.</p>
                            </div>
                        </div>
                        <small>From</small>
                        <h2>KES 1,500 <em>/mo</em></h2>
                        <ul>
                            <li>Expert guidance</li>
                            <li>Premium resources</li>
                            <li>Personalised support</li>
                            <li>Secure &amp; confidential</li>
                        </ul>
                        <a class="price-button" href="#">Choose Plan <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                    <article>
                        <div class="price-title">
                            <i class="fa-solid fa-people-group"></i>
                            <div>
                                <h3>For Families</h3>
                                <p>Support your family's learning, wellbeing and future development.</p>
                            </div>
                        </div>
                        <small>From</small>
                        <h2>KES 3,000 <em>/mo</em></h2>
                        <ul>
                            <li>All individual benefits</li>
                            <li>Family profiles</li>
                            <li>Progress tracking</li>
                            <li>Priority support</li>
                        </ul>
                        <a class="price-button" href="#">Choose Plan <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                    <article>
                        <div class="price-title">
                            <i class="fa-solid fa-briefcase"></i>
                            <div>
                                <h3>For Providers</h3>
                                <p>Join our network and grow your impact with verified opportunities.</p>
                            </div>
                        </div>
                        <small>From</small>
                        <h2>KES 2,500 <em>/mo</em></h2>
                        <ul>
                            <li>Verified opportunities</li>
                            <li>Profile &amp; visibility</li>
                            <li>Match notifications</li>
                            <li>Analytics dashboard</li>
                        </ul>
                        <a class="price-button featured" href="#">Choose Plan <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                    <article>
                        <div class="price-title">
                            <i class="fa-solid fa-building-columns"></i>
                            <div>
                                <h3>For Institutions</h3>
                                <p>Empower your organisation and reach more people with our solutions.</p>
                            </div>
                        </div>
                        <small>From</small>
                        <h2>KES 10,000 <em>/mo</em></h2>
                        <ul>
                            <li>Custom matching</li>
                            <li>Institution dashboard</li>
                            <li>Priority onboarding</li>
                            <li>Dedicated support</li>
                        </ul>
                        <a class="price-button" href="#">Choose Plan <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                </div>
            </div>
        </section>

        <section class="pricing-assurances">
            <article>
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <strong>No Hidden Fees</strong>
                    <p>What you see is what you pay.</p>
                </div>
            </article>
            <article>
                <i class="fa-solid fa-lock"></i>
                <div>
                    <strong>Secure Payments</strong>
                    <p>Your payments and data are always protected.</p>
                </div>
            </article>
            <article>
                <i class="fa-solid fa-arrows-rotate"></i>
                <div>
                    <strong>Flexible Plans</strong>
                    <p>Upgrade, downgrade or cancel anytime.</p>
                </div>
            </article>
            <article>
                <i class="fa-solid fa-headset"></i>
                <div>
                    <strong>Human Support</strong>
                    <p>Our team is here to support you.</p>
                </div>
            </article>
            <article>
                <i class="fa-solid fa-award"></i>
                <div>
                    <strong>Better Outcomes</strong>
                    <p>Quality support that delivers real impact.</p>
                </div>
            </article>
        </section>

    </main></main>
@include('partials.footer')
</body></html>