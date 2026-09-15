<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Choose a New Password | VALYNK</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body>
@include('partials.navbar')
<main class="mx-auto max-w-md px-5 py-20">
    <h1 class="text-3xl font-bold">Choose a new password</h1>
    @if($errors->any()) <p role="alert" class="my-4 text-rose-700">{{ $errors->first() }}</p> @endif
    <form method="POST" action="{{ route('password.update') }}" class="mt-5 grid gap-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label class="grid gap-1">Email address <input type="email" name="email" value="{{ old('email', $email) }}" autocomplete="email" required class="rounded-lg border border-slate-300 p-3"></label>
        <label class="grid gap-1">New password <input type="password" name="password" minlength="12" autocomplete="new-password" required class="rounded-lg border border-slate-300 p-3"></label>
        <label class="grid gap-1">Confirm new password <input type="password" name="password_confirmation" minlength="12" autocomplete="new-password" required class="rounded-lg border border-slate-300 p-3"></label>
        <button type="submit" class="rounded-lg bg-indigo-700 p-3 font-semibold text-white">Reset password</button>
    </form>
</main>
@include('partials.footer')
</body>
</html>
