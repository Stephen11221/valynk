<header class="focus-header">
    <a href="{{ route('home') }}"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK — Connect, Empower, Transform"></a>
    <nav aria-label="Main navigation">
        @foreach(['home' => 'Home', 'about' => 'About', 'how-it-works' => 'How It Works', 'solutions' => 'Solutions', 'families' => 'For Families', 'providers' => 'For Providers', 'institutions' => 'For Institutions', 'pricing' => 'Pricing', 'contact' => 'Contact'] as $routeName => $label)
            <a href="{{ route($routeName) }}">{{ $label }}</a>
        @endforeach
    </nav>
    <a class="focus-account" href="{{ route('dashboard') }}" aria-label="Go to your dashboard"><i class="fa-solid fa-user" aria-hidden="true"></i><i class="fa-solid fa-chevron-down" aria-hidden="true"></i></a>
</header>
