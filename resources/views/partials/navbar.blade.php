<header class="topbar">
    <nav class="shell nav" aria-label="Main navigation">
        <a class="brand brand-image" href="{{ url('/') }}" aria-label="VALYNK home">
            <img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK logo" class="brand-logo" style="width: min(170px, 38vw); height: auto; max-height: 46px; object-fit: contain;">
        </a>

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
            <a class="login" href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: 4px;"><i class="fa-solid fa-user-shield" style="font-size: 13px;"></i> Admin</a>
            <a class="button" href="#get-started">Get Started →</a>
            <label class="menu" for="nav-toggle" aria-label="Open menu">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </label>
        </div>
    </nav>
</header>