@php($user = $user ?? auth()->user())
<aside id="family-sidebar" class="family-sidebar" aria-label="Account navigation">
    <form class="family-mobile-search" action="{{ route('development.providers') }}" method="GET" role="search"><input type="search" name="q" placeholder="Search providers…" aria-label="Search providers" maxlength="100"><button type="submit" aria-label="Search providers"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></button></form>
    <nav>
        @foreach([
            ['house', 'Dashboard', route('dashboard'), true],
            ['people-group', 'My Children', route('development.home'), false],
            ['chart-column', 'Assessments & Reports', route('account.section', 'assessments'), false],
            ['link', 'My Matches', route('development.providers'), false],
            ['calendar-days', 'My Bookings', route('development.bookings'), false],
            ['credit-card', 'Payments', route('account.section', 'payments'), false],
            ['chart-line', 'Progress Tracking', route('account.section', 'progress'), false],
            ['comment-dots', 'Messages', route('account.section', 'messages'), false],
            ['heart', 'Explore Programmes', route('account.section', 'programmes'), false],
            ['user', 'My Profile', route('account.profile.edit'), false],
            ['gear', 'Settings', route('account.section', 'settings'), false],
            ['headset', 'Help & Support', route('account.section', 'help'), false],
        ] as [$icon, $label, $url, $active])
            @php($isActive = url()->current() === $url || ($label === 'My Children' && request()->routeIs('development.child')) || ($label === 'Assessments & Reports' && request()->routeIs('development.assessment', 'development.report')) || ($label === 'My Matches' && request()->routeIs('development.provider')))
            <a href="{{ $url }}" @if($isActive) aria-current="page" @endif><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>{{ $label }}</a>
        @endforeach
        @if($user->account_type === 'Family')<a href="{{ route('account.family.documents') }}" @if(request()->routeIs('account.family.*')) aria-current="page" @endif><i class="fa-solid fa-folder-open" aria-hidden="true"></i>My Documents</a>@endif
    </nav>
    <div class="family-sidebar-photo"><img src="{{ asset('images/about/family.png') }}" alt=""><p>Raising<br>Confident,<br>Capable<br>Children.</p></div>
</aside>
