<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ data_get($page, 'meta_description', 'Explore trusted support across every area of your child’s development — in school, in life and in the opportunities ahead.') }}">
    <title>{{ data_get($page, 'title', 'Solutions | VALYNK') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}?v={{ filemtime(public_path('css/layout.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/solutions.css') }}?v={{ filemtime(public_path('css/solutions.css')) }}">
</head>
<body class="solutions-page">
    @include('partials.navbar')

    <main id="top">
        <section class="solutions-hero" aria-labelledby="solutions-title">
            <img class="solutions-hero-photo" src="{{ asset('images/solutions/hero.png') }}" alt="Children and young adults looking ahead with confidence" fetchpriority="high" width="2172" height="724">
            <div class="solutions-copy">
                <p class="solutions-badge">{{ data_get($page, 'content.eyebrow', 'Solutions') }}</p>
                <h1 id="solutions-title">
                    @if (data_get($page, 'content.heading') && data_get($page, 'content.heading') !== "Different Needs.\nOne Powerful Approach.")
                        {!! nl2br(e(data_get($page, 'content.heading'))) !!}
                    @else
                        Your Child’s<br><span>Brighter Future</span> Starts Here.
                    @endif
                </h1>
                <p>{{ data_get($page, 'content.intro') && data_get($page, 'content.intro') !== 'VALYNK offers a range of solutions designed to help individuals, institutions and organisations unlock potential, build capability and achieve lasting results.' ? data_get($page, 'content.intro') : 'Explore trusted support across every area of your child’s development — in school, in life and in the opportunities ahead.' }}</p>
                <div class="solutions-actions">
                    <a class="solutions-button" href="#solutions">Explore All Solutions <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    <a class="solutions-guide-link" href="{{ route('development.landing') }}"><span>Not Sure Where to Start?<strong>Take the Guide</strong></span><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
            <p class="solutions-motto">Right<br>Support.<br>Brighter<br>Tomorrows.</p>
        </section>

        <section class="solutions-trust" aria-label="Our promise">
            @foreach ([['shield-halved', 'Trusted Providers', 'Only vetted, high-quality professionals and programmes.', 'navy'], ['people-group', 'Personalised Matching', 'Support that fits your child’s needs and goals.', 'blue'], ['seedling', 'Relevant at Every Stage', 'From early years to young adulthood.', 'green'], ['star', 'A Brighter Future', 'Build the capabilities for lifelong success.', 'gold']] as [$icon, $title, $description, $tone])
                <div class="trust-item tone-{{ $tone }}"><span class="solution-icon"><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i></span><div><h2>{{ $title }}</h2><p>{{ $description }}</p></div></div>
            @endforeach
        </section>

        <div class="solutions-layout">
            <div class="solutions-primary">
                <section id="solutions" aria-labelledby="our-solutions-title">
                    <header class="solutions-heading"><h2 id="our-solutions-title">Our Solutions</h2><p>Explore each solution area to find the right support for your child. Each solution brings together trusted providers and proven programmes to help them develop, perform and thrive.</p></header>
                    <div class="solutions-grid">
                        @foreach ($solutions as $key => $details)
                            <article class="solution-card tone-{{ $details['tone'] }}">
                                @if($details['image_url'])
                                    <img class="solution-photo solution-custom-photo" src="{{ $details['image_url'] }}" alt="" loading="lazy" referrerpolicy="no-referrer">
                                @else
                                    <div class="solution-photo solution-photo-{{ $details['photo'] }}" aria-hidden="true"></div>
                                @endif
                                <div class="solution-card-copy">
                                    <span class="solution-icon"><i class="fa-solid fa-{{ $details['icon'] }}" aria-hidden="true"></i></span>
                                    <h3>{{ $details['title'] }}</h3><p>{{ $details['description'] }}</p>
                                    <button type="button" class="solution-explore" data-solution-open="solution-{{ $key }}" aria-haspopup="dialog" aria-controls="solution-{{ $key }}" aria-label="Explore {{ $details['title'] }}">Explore <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="solutions-stages" aria-labelledby="stages-title">
                    <h2 id="stages-title">Relevant at Every Stage</h2>
                    <p>Our solutions are tailored to be relevant across all stages of your child’s journey — while remaining adaptive to individual needs.</p>
                    <ol class="stages-list">
                        @foreach ([['pink', 'seedling', 'Early Years', '5 – 6', 'Pre-Primary (PP1–2)', 'Build strong foundations'], ['blue', 'child', 'Lower Primary', '7 – 8', 'Grade 1 – 3', 'Develop key skills and curiosity'], ['teal', 'people-group', 'Upper Primary', '9 – 11', 'Grade 4 – 6', 'Strengthen capability and identity'], ['gold', 'person', 'Lower Secondary', '12 – 14', 'Grade 7 – 9', 'Prepare for opportunities and independence'], ['orange', 'person', 'Upper Secondary', '15 – 17', 'Grade 10 – 12', 'Transition with confidence to higher education, work and life'], ['purple', 'graduation-cap', 'Young Adulthood', '18+', 'Beyond School', 'Build a fulfilling future']] as [$tone, $icon, $title, $age, $grade, $description])
                            <li class="tone-{{ $tone }}"><div class="stage-label"><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><div><h3>{{ $title }}</h3><span>({{ $age }})</span><span>{{ $grade }}</span></div></div><p>{{ $description }}</p></li>
                        @endforeach
                    </ol>
                </section>
            </div>

            <aside class="solutions-sidebar" aria-label="Help choosing support">
                <section class="solutions-why">
                    <h2>Why Choose VALYNK?</h2>
                    @foreach ([['calendar-check', 'Verified & Vetted Experts', 'Only qualified, trusted professionals.'], ['shield-halved', 'Evidence-Based Matching', 'Matches based on your child’s needs and goals.'], ['link', 'Age-Sensitive Guidance', 'Support that fits your child’s age and developmental stage.'], ['star', 'Whole-Child Approach', 'Mind, skills, direction and wellbeing — all connected.'], ['user', 'Track Progress & Outcomes', 'See what’s working and plan what’s next.']] as [$icon, $title, $description])
                        <div class="solutions-reason"><span><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i></span><div><h3>{{ $title }}</h3><p>{{ $description }}</p></div></div>
                    @endforeach
                </section>
                <section class="solutions-quick-guide"><div><h2>Not sure where to start?</h2><p>Explore our approach and find the best starting point for your child.</p><a class="solutions-button" href="{{ route('development.landing') }}">Take the Quick Guide <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div><i class="fa-solid fa-clipboard-check guide-illustration" aria-hidden="true"></i></section>
                <section class="solutions-help"><h2>Need help choosing?</h2><p>Talk to our Family Support Team.</p><a href="{{ route('contact') }}"><i class="fa-regular fa-comment-dots" aria-hidden="true"></i> Contact our team <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></section>
            </aside>
        </div>

        <section class="solutions-process" aria-labelledby="process-title">
            <h2 id="process-title">How VALYNK Helps You Find the Right Support</h2>
            <ol>
                @foreach ([['blue', 'magnifying-glass', 'Explore', 'Discover solutions that match your child’s interests and goals.'], ['purple', 'file-lines', 'Tell Us More', 'Complete a short assessment to help us understand your child’s needs.'], ['green', 'people-group', 'Get Matched', 'We identify suitable providers and programmes based on your child’s profile.'], ['gold', 'calendar-days', 'See Options', 'View upcoming intakes or available delivery arrangements.'], ['pink', 'link', 'Connect', 'Express interest or enrol directly with the provider.']] as [$tone, $icon, $title, $description])
                    <li class="tone-{{ $tone }}"><span class="process-number">{{ $loop->iteration }}</span><i class="fa-solid fa-{{ $icon }} process-icon" aria-hidden="true"></i><div><h3>{{ $title }}</h3><p>{{ $description }}</p></div>@unless($loop->last)<i class="fa-solid fa-chevron-right process-arrow" aria-hidden="true"></i>@endunless</li>
                @endforeach
            </ol>
        </section>
    </main>

    @foreach($solutions as $key => $details)
        @include('partials.solution-dialog', ['key' => $key, 'details' => $details])
    @endforeach
    <script src="{{ asset('js/solutions.js') }}?v={{ filemtime(public_path('js/solutions.js')) }}" defer></script>
    @include('partials.footer')
</body>
</html>
