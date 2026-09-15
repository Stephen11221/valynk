<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | VALYNK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body>
@include('partials.navbar')
<main class="mx-auto max-w-md px-5 py-20">
    <h1 class="text-3xl font-bold">Reset your password</h1>
    <p class="my-3">Enter your account email and we’ll send a reset link.</p>
    @if(session('status')) <p role="status" class="my-4 text-emerald-700">{{ session('status') }}</p> @endif
    @error('email') <p role="alert" class="my-4 text-rose-700">{{ $message }}</p> @enderror
    <form method="POST" action="{{ route('password.email') }}" class="grid gap-4">
        @csrf
        <label class="grid gap-1">Email address <input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required class="rounded-lg border border-slate-300 p-3"></label>
        <button type="submit" class="rounded-lg bg-indigo-700 p-3 font-semibold text-white">Send reset link</button>
    </form>
    <a href="{{ route('login') }}" class="mt-5 inline-block">Back to login</a>
</main>
@include('partials.footer')
</body>
</html>
