@extends('layouts.account')

@section('title', 'Provider Dashboard')

@section('content')
@include('account.partials.status')
@php $profile = $user->providerProfile; $approval = $profile?->status ?? 'Pending'; $verification = $profile?->verification ?? 'Not Verified'; @endphp
<section class="rounded-2xl bg-indigo-950 p-6 text-white shadow-sm sm:p-8">
    <p class="text-xs font-bold uppercase tracking-widest text-indigo-200">Provider account</p>
    <h1 class="mt-2 text-2xl font-extrabold sm:text-3xl">Your Provider Dashboard</h1>
    <p class="mt-2 max-w-2xl text-sm text-indigo-100">Welcome, {{ $user->name }}. Keep your service details current and follow your review status here.</p>
    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('account.profile.edit') }}" class="rounded-lg bg-amber-400 px-5 py-2.5 text-sm font-bold text-slate-950 hover:bg-amber-300">Manage service details →</a>
        <a href="{{ route('providers') }}" class="rounded-lg border border-indigo-300 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-900">Provider solutions</a>
    </div>
</section>
<div class="mt-6 grid gap-4 sm:grid-cols-2">
    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm"><h2 class="text-sm font-bold text-slate-500">Approval status</h2><p class="mt-2 text-xl font-extrabold text-slate-900">{{ $approval }}</p><p class="mt-2 text-xs text-slate-600">VALYNK administrators manage approval.</p></section>
    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm"><h2 class="text-sm font-bold text-slate-500">Verification status</h2><p class="mt-2 text-xl font-extrabold text-slate-900">{{ $verification }}</p><p class="mt-2 text-xs text-slate-600">Your verified status appears here after review.</p></section>
</div>
<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">@include('account.partials.details')</div>
    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900">Your service profile</h2>
        <dl class="mt-5 space-y-4"><div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Service</dt><dd class="mt-1 text-sm font-medium">{{ $profile?->service ?: 'Not added yet' }}</dd></div><div><dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Category</dt><dd class="mt-1 text-sm font-medium">{{ $profile?->category ?: 'Not added yet' }}</dd></div></dl>
        @if(!$profile?->service || !$profile?->category) <p class="mt-4 text-xs text-amber-700">Add your service and category so your profile is complete.</p> @endif
        <a href="{{ route('account.profile.edit') }}" class="mt-5 inline-block text-sm font-semibold text-indigo-700 hover:underline">Edit service profile →</a>
    </section>
</div>
@endsection
