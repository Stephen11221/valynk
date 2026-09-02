<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Evidence-backed matching that delivers.">
    <title>VALYNK | The link that delivers</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main id="top">
        <section class="hero">
            <div class="shell hero-grid">
                <div class="hero-copy">
                    <p class="eyebrow">Evidence-backed matching that delivers</p>
                    <h1>
                        The Right Connection.<br>
                        Measurable <span class="accent">Impact.</span>
                    </h1>
                    <div class="rule"></div>
                    <p>
                        VALYNK connects people and organisations to the right expertise and opportunities
                        through evidence-based matching, so every connection creates meaningful outcomes.
                    </p>
                    <div class="hero-buttons">
                        <a class="button" href="#get-started">
                            Find a Match&nbsp; <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a class="button outline" href="#institutions">
                            <i class="fa-solid fa-building-columns"></i> &nbsp; For Institutions
                        </a>
                    </div>
                </div>

                <div class="hero-art" role="img" aria-label="Professionals collaborating around a laptop"></div>
            </div>
        </section>

        <section class="trust-strip">
            <div class="shell trust-grid">
                <div class="trust">
                    <div class="trust-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <div>
                        <strong>Trusted &amp; Verified</strong>
                        <span>All Providers are verified for quality and reliability.</span>
                    </div>
                </div>

                <div class="trust">
                    <div class="trust-icon"><i class="fa-regular fa-clock"></i></div>
                    <div>
                        <strong>Save Time</strong>
                        <span>Intelligent matching that saves hours of searching.</span>
                    </div>
                </div>

                <div class="trust">
                    <div class="trust-icon"><i class="fa-solid fa-people-group"></i></div>
                    <div>
                        <strong>Better Outcomes</strong>
                        <span>Stronger partnerships that create real, measurable impact.</span>
                    </div>
                </div>

                <div class="trust">
                    <div class="trust-icon"><i class="fa-solid fa-globe"></i></div>
                    <div>
                        <strong>Wide Network</strong>
                        <span>Access a growing network across multiple sectors.</span>
                    </div>
                </div>

                <div class="trust">
                    <div class="trust-icon"><i class="fa-solid fa-award"></i></div>
                    <div>
                        <strong>Proven Impact</strong>
                        <span>Evidence-backed approach for meaningful results.</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="shell impact">
            <div class="impact-grid">
                <div class="metric">
                    <span class="symbol"><i class="fa-solid fa-building"></i></span>
                    <div>
                        <b>3,000+</b>
                        <small>Successful<br>Matches</small>
                    </div>
                </div>

                <div class="metric">
                    <span class="symbol"><i class="fa-solid fa-people-group"></i></span>
                    <div>
                        <b>542+</b>
                        <small>Verified<br>Providers</small>
                    </div>
                </div>

                <div class="metric">
                    <span class="symbol"><i class="fa-solid fa-building-columns"></i></span>
                    <div>
                        <b>231+</b>
                        <small>Institutions<br>Connected</small>
                    </div>
                </div>

                <div class="metric">
                    <span class="symbol"><i class="fa-solid fa-globe"></i></span>
                    <div>
                        <b>15+</b>
                        <small>Sectors<br>Served</small>
                    </div>
                </div>

                <div class="metric">
                    <span class="symbol"><i class="fa-solid fa-handshake"></i></span>
                    <div>
                        <b>98%</b>
                        <small>Client Satisfaction<br>Rate</small>
                    </div>
                </div>

                <div class="metric">
                    <span class="symbol"><i class="fa-solid fa-chart-line"></i></span>
                    <b class="outcome">
                        Stronger <em>Outcomes.</em><br>
                        <em>Together.</em>
                    </b>
                </div>
            </div>
        </section>

        <section class="shell process" id="how-it-works">
            <div>
                <p class="section-label">How it works</p>
                <h2>Simple. Smart. Seamless.</h2>
            </div>

            <div class="steps">
                <div class="step">
                    <span class="step-number">1</span>
                    <div>
                        <strong>Tell Us Your Need</strong>
                        <p>Share your requirements in a few simple steps.</p>
                    </div>
                </div>

                <div class="step">
                    <span class="step-number">2</span>
                    <div>
                        <strong>We Match</strong>
                        <p>Our system matches you with the most suitable options.</p>
                    </div>
                </div>

                <div class="step">
                    <span class="step-number">3</span>
                    <div>
                        <strong>Review &amp; Connect</strong>
                        <p>Review match evidence and connect with confidence.</p>
                    </div>
                </div>

                <div class="step">
                    <span class="step-number">4</span>
                    <div>
                        <strong>Deliver Impact</strong>
                        <p>Build partnerships that achieve your goals.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="shell solutions" id="solutions">
            <p class="section-label">Solutions</p>

            <div class="solution-grid">
                <article class="solution" id="families">
                    <div class="solution-icon"><i class="fa-solid fa-people-roof"></i></div>
                    <h3>For Families</h3>
                    <p>Find trusted specialists, support services and opportunities for your family's growth.</p>
                    <a href="{{ route('families') }}">Explore <i class="fa-solid fa-arrow-right"></i></a>
                </article>

                <article class="solution" id="providers">
                    <div class="solution-icon"><i class="fa-solid fa-user-tie"></i></div>
                    <h3>For Providers</h3>
                    <p>Grow your practice and reach more people looking for your expertise.</p>
                    <a href="#get-started">Explore <i class="fa-solid fa-arrow-right"></i></a>
                </article>

                <article class="solution" id="institutions">
                    <div class="solution-icon"><i class="fa-solid fa-building-columns"></i></div>
                    <h3>For Institutions</h3>
                    <p>Connect with verified providers and partners that align with your goals.</p>
                    <a href="#get-started">Explore <i class="fa-solid fa-arrow-right"></i></a>
                </article>

                <article class="solution">
                    <div class="solution-icon"><i class="fa-solid fa-briefcase"></i></div>
                    <h3>Corporate Solutions</h3>
                    <p>Custom programs and partnerships to drive performance and outcomes.</p>
                    <a href="#get-started">Explore <i class="fa-solid fa-arrow-right"></i></a>
                </article>

                <article class="solution">
                    <div class="solution-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                    <h3>Community Impact</h3>
                    <p>Collaborate for social impact and measurable change in communities.</p>
                    <a href="#get-started">Explore <i class="fa-solid fa-arrow-right"></i></a>
                </article>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>