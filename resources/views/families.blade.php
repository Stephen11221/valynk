<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Find trusted child development support with VALYNK.">
    <title>For Families | VALYNK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/families.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main id="top">
        <section class="family-hero">
            <div class="family-copy">
                <p class="family-badge">Supporting children aged 5-18</p>
                <h1>
                    The right support.<br>
                    The right time. <span>The right impact.</span>
                </h1>
                <p>VALYNK helps families find the right specialist support for your child, at every stage of growth and development.</p>
                <div class="family-actions">
                    <a class="button" href="#family-solutions">Find Support for My Child <i class="fa-solid fa-arrow-right"></i></a>
                    <a class="family-guide" href="#quick-guide">Not Sure Where to Start?<strong>Take the Guide <i class="fa-solid fa-arrow-right"></i></strong></a>
                </div>
            </div>
            <div class="family-hero-image" role="img" aria-label="Family looking at a tablet together"></div>
        </section>
    <section class="family-layout">
            <div class="family-main">
                <div class="journey-heading">
                    <div>
                        <h2>The VALYNK Child Development Journey</h2>
                        <p>A flexible, evidence-guided pathway. Your child can enter at any stage based on their current needs.</p>
                    </div>
                    <a href="#family-solutions">Learn more about the journey <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="journey">
                    <article>
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <h3>1. Understand</h3>
                        <p>Know your child's strengths, needs, challenges and potential.</p>
                    </article>
                    <article>
                        <i class="fa-solid fa-dumbbell"></i>
                        <h3>2. Strengthen</h3>
                        <p>Build mindset, habits, focus, confidence and resilience.</p>
                    </article>
                    <article>
                        <i class="fa-solid fa-compass"></i>
                        <h3>3. Direct</h3>
                        <p>Explore strengths, interests and possibilities.</p>
                    </article>
                    <article>
                        <i class="fa-solid fa-chart-line active-icon"></i>
                        <h3>4. Develop</h3>
                        <p>Develop academic, talent, leadership and life skills.</p>
                    </article>
                    <article>
                        <i class="fa-solid fa-seedling active-icon"></i>
                        <h3>5. Thrive</h3>
                        <p>Track progress, measure outcomes and evolve.</p>
                    </article>
                </div>

                <div class="solutions-heading">
                    <div>
                        <h2>Explore All Family Solutions</h2>
                        <p>Choose the area you want support in. We'll match you with the most suitable experts.</p>
                    </div>
                    <a href="#family-solutions">View all solutions <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <div class="family-solutions" id="family-solutions">
                    <article>
                        <i class="fa-solid fa-user-tie"></i>
                        <h3>Performance &amp; Potential</h3>
                        <p>Improve focus, confidence, discipline, habits and academic performance.</p>
                        <a href="#">Explore solutions <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                    <article>
                        <i class="fa-solid fa-compass"></i>
                        <h3>Career Discovery &amp; Future Direction</h3>
                        <p>Discover strengths, explore careers and plan the right future pathways.</p>
                        <a href="#">Explore solutions <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                    <article>
                        <i class="fa-solid fa-book-open"></i>
                        <h3>Academic &amp; Learning Support</h3>
                        <p>Subject support, tutoring and learning programs tailored to your child's needs.</p>
                        <a href="#">Explore solutions <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                    <article>
                        <i class="fa-solid fa-brain"></i>
                        <h3>Social &amp; Emotional Development</h3>
                        <p>Build confidence, resilience, social skills and emotional intelligence.</p>
                        <a href="#">Explore solutions <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                    <article>
                        <i class="fa-solid fa-heart"></i>
                        <h3>Health &amp; Wellbeing</h3>
                        <p>Physical, mental and emotional wellness support for your family.</p>
                        <a href="#">Explore solutions <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                    <article>
                        <i class="fa-regular fa-star"></i>
                        <h3>Enrichment &amp; Talent</h3>
                        <p>Unlock your child's potential through creativity, sports, arts and leadership.</p>
                        <a href="#">Explore solutions <i class="fa-solid fa-arrow-right"></i></a>
                    </article>
                </div>
            </div>
        </section>

    </main></main>
@include('partials.footer')
</body></html>