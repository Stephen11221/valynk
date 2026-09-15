@extends('layouts.account')

@section('title', 'Institution Dashboard')

@section('content')
@include('account.partials.status')
<section class="rounded-2xl bg-slate-900 p-6 text-white shadow-sm sm:p-8">
    <p class="text-xs font-bold uppercase tracking-widest text-sky-300">Institution account</p>
    <h1 class="mt-2 text-2xl font-extrabold sm:text-3xl">Your Institution Dashboard</h1>
    <p class="mt-2 max-w-2xl text-sm text-slate-200">Welcome, {{ $user->name }}. Manage your organisation’s contact details and explore VALYNK institution solutions.</p>
    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('institutions') }}" class="rounded-lg bg-sky-400 px-5 py-2.5 text-sm font-bold text-slate-950 hover:bg-sky-300">Explore institution solutions →</a>
        <a href="{{ route('account.profile.edit') }}" class="rounded-lg border border-slate-400 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Update account details</a>
    </div>
</section>
<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">@include('account.partials.details')</div>
    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900">Organisation contact</h2>
        <p class="mt-3 text-sm text-slate-600">{{ $user->phone && $user->location ? 'Your phone and location are on your account.' : 'Add your phone and location so your account details are complete.' }}</p>
        <dl class="mt-5 space-y-3"><div><dt class="text-xs font-semibold uppercase text-slate-500">Phone</dt><dd class="text-sm">{{ $user->phone ?: 'Not added yet' }}</dd></div><div><dt class="text-xs font-semibold uppercase text-slate-500">Location</dt><dd class="text-sm">{{ $user->location ?: 'Not added yet' }}</dd></div></dl>
        <a href="{{ route('account.profile.edit') }}" class="mt-5 inline-block text-sm font-semibold text-indigo-700 hover:underline">Review contact details →</a>
    </section>
</div>
@endsection
