@extends('layouts.account')

@section('title', 'Individual Dashboard')

@section('content')
@include('account.partials.status')
<section class="rounded-2xl bg-[#061633] p-6 text-white shadow-sm sm:p-8">
    <p class="text-xs font-bold uppercase tracking-widest text-amber-300">Individual account</p>
    <h1 class="mt-2 text-2xl font-extrabold sm:text-3xl">Your Individual Dashboard</h1>
    <p class="mt-2 max-w-2xl text-sm text-slate-200">Welcome, {{ $user->name }}. Explore support that fits you and manage your account details.</p>
    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('solutions') }}" class="rounded-lg bg-amber-400 px-5 py-2.5 text-sm font-bold text-slate-950 hover:bg-amber-300">Explore solutions →</a>
        <a href="{{ route('account.profile.edit') }}" class="rounded-lg border border-slate-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Edit my profile</a>
    </div>
</section>
<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2">@include('account.partials.details')</div>
    <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-bold text-slate-900">Find your next step</h2>
        <p class="mt-3 text-sm text-slate-600">Learn how VALYNK connects you with suitable services.</p>
        <a href="{{ route('how-it-works') }}" class="mt-5 inline-block text-sm font-semibold text-indigo-700 hover:underline">How it works →</a>
        <a href="{{ route('pricing') }}" class="mt-3 block text-sm font-semibold text-indigo-700 hover:underline">View pricing →</a>
    </section>
</div>
@endsection
