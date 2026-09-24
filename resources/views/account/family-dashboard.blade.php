@extends('layouts.account')

@section('title', 'Family Dashboard')

@section('content')
<div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:15px;padding:20px;margin-bottom:24px;border:1px solid #e5dff4;border-radius:12px;background:#f6f0ff;color:#151447"><div><strong style="font-size:20px">Your child’s development journey</strong><p style="margin:5px 0">Assess needs, explore providers and follow your next steps.</p></div><a href="{{ route('development.home') }}" style="background:#5820a3;color:white;padding:12px 20px;border-radius:7px;font-weight:700">Open family journey →</a></div>
@include('account.partials.status')
<section class="rounded-2xl bg-teal-950 p-6 text-white shadow-sm sm:p-8">
    <p class="text-xs font-bold uppercase tracking-widest text-teal-200">Family account</p>
    <h1 class="mt-2 text-2xl font-extrabold sm:text-3xl">Your Family Dashboard</h1>
    <p class="mt-2 max-w-2xl text-sm text-teal-100">Welcome, {{ $user->name }}. Find trusted support for your family and keep your contact details ready.</p>
    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('account.family.documents') }}" class="rounded-lg bg-violet-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-violet-500">My documents →</a>
        <a href="{{ route('families') }}" class="rounded-lg bg-amber-400 px-5 py-2.5 text-sm font-bold text-slate-950 hover:bg-amber-300">Explore family support →</a>
        <a href="{{ route('account.profile.edit') }}" class="rounded-lg border border-teal-300 px-5 py-2.5 text-sm font-semibold text-white hover:bg-teal-900">Update family contact</a>
    </div>
</section>
<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">@include('account.partials.details')</div>
    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900">Start your support journey</h2>
        <p class="mt-3 text-sm text-slate-600">See the steps VALYNK uses to connect families with support.</p>
        <a href="{{ route('how-it-works') }}" class="mt-5 inline-block text-sm font-semibold text-indigo-700 hover:underline">How matching works →</a>
        <p class="mt-6 border-t border-slate-100 pt-4 text-xs text-slate-500">Your account phone: {{ $user->phone ?: 'Not added yet' }}</p>
    </section>
</div>
@endsection
