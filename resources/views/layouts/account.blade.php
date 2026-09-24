<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | VALYNK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&amp;family=Manrope:wght@600;700;800&amp;display=swap">
    <style>
        @layer base {
            body { font-family: 'DM Sans', sans-serif; }
            h1, h2, h3, h4 { font-family: 'Manrope', sans-serif; }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 @yield('body-class')">
    @hasSection('header')
        @yield('header')
    @else
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-5 py-4">
            <a href="{{ route('dashboard') }}" aria-label="VALYNK dashboard"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK" class="h-10 w-auto"></a>
            <nav class="flex flex-wrap items-center gap-3 text-base font-semibold" aria-label="Account navigation">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-indigo-700' : 'text-slate-600' }} hover:text-indigo-700">Dashboard</a>
                @if (auth()->user()?->account_type === 'Family')
                    <a href="{{ route('account.family.documents') }}" class="text-slate-600 hover:text-indigo-700">Documents</a>
                @endif
                <a href="{{ route('account.profile.edit') }}" class="{{ request()->routeIs('account.profile.*') ? 'text-indigo-700' : 'text-slate-600' }} hover:text-indigo-700">My profile</a>
                <a href="{{ route('development.home') }}" class="text-slate-600 hover:text-indigo-700">Child development</a>
                <a href="{{ route('home') }}" class="text-slate-600 hover:text-indigo-700">Website</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="rounded-lg border border-slate-300 px-3 py-2 text-slate-700 hover:bg-slate-50">Log out</button></form>
            </nav>
        </div>
    </header>
    @endif
    <main class="mx-auto max-w-6xl px-5 py-8 sm:py-10">
        @yield('content')
    </main>
    @yield('footer')
</body>
</html>
