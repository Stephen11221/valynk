<dialog id="solution-{{ $key }}" class="solution-dialog tone-{{ $details['tone'] }}" aria-labelledby="solution-title-{{ $key }}">
    <button type="button" class="solution-dialog-close" data-solution-close aria-label="Close solution details" autofocus><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
    <section class="solution-dialog-hero">
        @if($details['image_url'])
            <img class="solution-dialog-image" src="{{ $details['image_url'] }}" alt="" loading="lazy" referrerpolicy="no-referrer">
        @else
            <div class="solution-dialog-image solution-photo solution-photo-{{ $details['photo'] }}" aria-hidden="true"></div>
        @endif
        <div class="solution-dialog-intro">
            <img class="solution-dialog-logo" src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK" width="180" height="55">
            <span class="solution-dialog-badge">Solution</span>
            <h2 id="solution-title-{{ $key }}">{{ $details['title'] }}</h2>
            <p>{{ $details['description'] }}</p>
            <ul class="solution-highlights">@foreach($details['highlights'] as $highlight)<li><i class="fa-solid fa-{{ ['brain', 'bullseye', 'person', 'star'][$loop->index] }}" aria-hidden="true"></i><strong>{{ $highlight }}</strong></li>@endforeach</ul>
        </div>
        @if($details['tagline'])<p class="solution-dialog-tagline">{{ $details['tagline'] }}</p>@endif
        <div class="solution-age"><i class="fa-solid fa-people-group" aria-hidden="true"></i><strong>{{ $details['age_range'] }}</strong></div>
    </section>
    <div class="solution-dialog-body">
        <section class="solution-support">
            <h3>Key Areas of Support</h3><p>{{ $details['support_intro'] }}</p>
            <div class="solution-support-grid">
                @foreach($details['areas'] as $area)
                    <article class="solution-support-card tone-{{ $area['tone'] }}">
                        @if($area['image_url'])<img class="solution-photo solution-custom-photo" src="{{ $area['image_url'] }}" alt="" loading="lazy" referrerpolicy="no-referrer">@else<div class="solution-photo solution-photo-{{ $area['photo'] }}" aria-hidden="true"></div>@endif
                        <div class="solution-support-copy"><span class="solution-icon"><i class="fa-solid fa-{{ $area['icon'] }}" aria-hidden="true"></i></span><h4>{{ $area['title'] }}</h4><ul>@foreach($area['points'] as $point)<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i><span>{{ $point }}</span></li>@endforeach</ul></div>
                    </article>
                @endforeach
            </div>
        </section>
        <aside class="solution-dialog-sidebar">
            <section class="solution-benefits"><h3><i class="fa-solid fa-star" aria-hidden="true"></i> Key Benefits for Your Child</h3><ul>@foreach($details['benefits'] as $benefit)<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i><span>{{ $benefit }}</span></li>@endforeach</ul></section>
            <section class="solution-connect"><h3>Ready to take the next step?</h3><p>Get connected with trusted providers and programmes that match your child’s needs.</p><a class="solutions-button" href="{{ route($details['cta_route']) }}">{{ $details['cta_label'] }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></section>
        </aside>
    </div>
    <div class="solution-dialog-trust">
        @foreach([['shield-halved', 'Verified Providers', 'Only vetted, high-quality professionals and programmes.'], ['people-group', 'Personalised Matching', 'Support that fits your child’s needs and goals.'], ['seedling', 'Relevant at Every Stage', 'From early years to young adulthood.'], ['star', 'A Brighter Future', 'Build the capabilities for lifelong success.']] as [$icon, $title, $description])
            <div><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><p><strong>{{ $title }}</strong><span>{{ $description }}</span></p></div>
        @endforeach
    </div>
</dialog>
