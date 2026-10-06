@php($user = $user ?? auth()->user())
<header class="family-topbar">
    <a class="family-brand" href="{{ route('dashboard') }}" aria-label="VALYNK dashboard"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK"></a>
    <button type="button" class="family-menu-toggle" aria-label="Open account navigation" aria-expanded="false" aria-controls="family-sidebar"><i class="fa-solid fa-bars" aria-hidden="true"></i></button>
    <form class="family-search" action="{{ route('development.providers') }}" method="GET" role="search"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><input type="search" name="q" placeholder="Search for programmes, providers or support…" aria-label="Search providers" maxlength="100"><button type="submit" aria-label="Search"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></form>
    <a class="family-notifications" href="{{ route('dashboard') }}#recent-activity" aria-label="View recent activity"><i class="fa-solid fa-bell" aria-hidden="true"></i></a>
    <details class="family-user-menu"><summary><span class="family-avatar">{{ mb_substr($user->name, 0, 1) }}</span><span>Welcome, {{ $user->name }}<small>{{ $user->account_type }} Account</small></span><i class="fa-solid fa-chevron-down" aria-hidden="true"></i></summary><div><a href="{{ route('account.profile.edit') }}">My profile</a><a href="{{ route('home') }}">Visit website</a><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit">Log out</button></form></div></details>
</header>
