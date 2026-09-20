@extends('layouts.account')

@section('title', 'Account Dashboard')

@section('content')
@include('account.partials.status')
<section class="rounded-2xl bg-slate-900 p-6 text-white shadow-sm sm:p-8">
    <p class="text-sm font-bold uppercase tracking-widest text-amber-300">{{ $user->account_type }} account</p>
    <h1 class="mt-2 text-4xl font-extrabold sm:text-5xl">{{ $user->account_type === 'Partner / Other' ? 'Your Partner Dashboard' : 'Your Dashboard' }}</h1>
    <p class="mt-2 max-w-2xl text-base text-slate-200">Welcome, {{ $user->name }}. Keep your account details current and learn more about VALYNK.</p>
    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('account.profile.edit') }}" class="rounded-lg bg-amber-400 px-5 py-2.5 text-base font-bold text-slate-950 hover:bg-amber-300">Edit my profile →</a>
        <a href="{{ route('about') }}" class="rounded-lg border border-slate-400 px-5 py-2.5 text-base font-semibold text-white hover:bg-slate-800">About VALYNK</a>
    </div>
</section>
<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">@include('account.partials.details')</div>
    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm"><h2 class="text-3xl font-bold text-slate-900">Explore the platform</h2><p class="mt-3 text-base text-slate-600">Browse VALYNK’s available solutions.</p><a href="{{ route('solutions') }}" class="mt-5 inline-block text-base font-semibold text-indigo-700 hover:underline">View solutions →</a></section>
</div>
@endsection
