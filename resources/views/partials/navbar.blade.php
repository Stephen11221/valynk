<header class="topbar site-header">
    <nav class="shell nav" aria-label="Main navigation">
        <a class="brand brand-image" href="{{ url('/') }}" aria-label="VALYNK home">
            <img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK logo" class="brand-logo" style="width: min(170px, 38vw); height: auto; max-height: 46px; object-fit: contain;">
        </a>

        <span class="visually-hidden">VALYNK primary navigation</span>

        <input
            class="nav-toggle"
            id="nav-toggle"
            type="checkbox"
            aria-label="Toggle navigation menu"
        >

        <div class="links">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
            <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
            <a class="{{ request()->routeIs('how-it-works') ? 'active' : '' }}" href="{{ route('how-it-works') }}">How It Works</a>
            <a class="{{ request()->routeIs('solutions') ? 'active' : '' }}" href="{{ route('solutions') }}">Solutions</a>
            <a class="{{ request()->routeIs('families') ? 'active' : '' }}" href="{{ route('families') }}">For Families</a>
            <a class="{{ request()->routeIs('providers') ? 'active' : '' }}" href="{{ route('providers') }}">For Providers</a>
            <a class="{{ request()->routeIs('institutions') ? 'active' : '' }}" href="{{ route('institutions') }}">For Institutions</a>
            <a class="{{ request()->routeIs('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">Pricing</a>
            <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
        </div>

        <div class="actions">
            <button class="search" aria-label="Search">
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
            </button>
            @auth
                <a class="login" href="{{ auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="button" type="submit">Log out</button></form>
            @else
                <a class="login" href="{{ route('login') }}">Login</a>
                <a class="button" href="{{ route('register') }}">Get Started →</a>
            @endauth
            <label class="menu" for="nav-toggle" aria-label="Open menu">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </label>
        </div>
    </nav>
</header>
