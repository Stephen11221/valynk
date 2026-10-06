<dialog id="solution-{{ $key }}" class="solution-dialog tone-{{ $details['tone'] }}" aria-labelledby="solution-title-{{ $key }}">
    <button type="button" class="solution-dialog-close" data-solution-close aria-label="Close solution details" autofocus><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
    <section class="solution-dialog-hero">
        @if($details['display_image_url'])
            <img class="solution-dialog-image" src="{{ $details['display_image_url'] }}" alt="" loading="lazy" referrerpolicy="no-referrer">
        @elseif($key === 'performance-confidence')
            <img class="solution-dialog-image" src="{{ asset('images/solutions/confidence-hero.png') }}" alt="" loading="lazy">
        @else
            <div class="solution-dialog-image solution-photo solution-photo-{{ $details['photo'] }}" aria-hidden="true"></div>
        @endif
        <div class="solution-dialog-intro">
            <div class="solution-dialog-label">
                <span class="solution-dialog-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <div><p>{{ $details['title'] }}</p>@if($key === 'performance-confidence')<span>SOL-PCPD</span>@endif</div>
            </div>
            <h2 id="solution-title-{{ $key }}">{{ $key === 'performance-confidence' && $details['title'] === config('solutions.performance-confidence.title') ? 'Build Confidence, Resilience and a Positive Self-Image' : $details['title'] }}</h2>
            <p>{{ $details['description'] }}</p>
        </div>
        @if($details['tagline'])<p class="solution-dialog-tagline">{{ $details['tagline'] }}</p>@endif
        <div class="solution-overview">
            <section class="solution-overview-item">
                <span class="solution-overview-icon"><i class="fa-solid fa-people-group" aria-hidden="true"></i></span>
                <div><h3>Who It’s For</h3><p>{{ $details['age_range'] }}</p></div>
            </section>
            <section class="solution-overview-item">
                <span class="solution-overview-icon"><i class="fa-solid fa-bullseye" aria-hidden="true"></i></span>
                <div><h3>Real-World Outcomes</h3><p>{{ $key === 'performance-confidence' && $details['benefits'] === config('solutions.performance-confidence.benefits') ? 'Greater self-belief, better focus, stronger habits and improved communication and relationships.' : implode(', ', $details['benefits']) }}</p></div>
            </section>
            <section class="solution-overview-item">
                <span class="solution-overview-icon"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i></span>
                <div><h3>How It Helps</h3><p>Through expert-led programmes and support, learners develop practical tools and real-life skills to manage challenges and make positive choices.</p></div>
            </section>
        </div>
    </section>
    <div class="solution-dialog-body">
        <section class="solution-support">
            <h3>Key Areas Addressed</h3><p>{{ $details['support_intro'] }}</p>
            <div class="solution-support-grid">
                @foreach($details['areas'] as $area)
                    <article class="solution-support-card">
                        <div class="solution-support-copy">
                            <div class="solution-support-marker"><span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><i class="fa-solid fa-{{ $area['icon'] }}" aria-hidden="true"></i></div>
                            <h4>{{ $area['title'] }}</h4>
                            <ul>@foreach($area['points'] as $point)<li>{{ $point }}</li>@endforeach</ul>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
        <section class="solution-connect">
            <span class="solution-connect-icon"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i></span>
            <div class="solution-connect-copy"><h3>Ready to find the right support?</h3><p>Click below to get connected. You’ll be taken to a short sign-up form and a few quick questions so we can understand your needs better.</p></div>
            <div class="solution-connect-action"><a class="solutions-button" href="{{ route($details['cta_route'], $details['cta_route'] === 'get-connected' ? ['solution' => $key] : []) }}">{{ $details['cta_label'] }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a><p>It only takes a few minutes.</p></div>
        </section>
    </div>
</dialog>
