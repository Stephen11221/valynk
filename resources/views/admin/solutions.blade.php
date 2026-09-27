@extends('layouts.admin')
@section('title', 'Solutions')
@section('header_title', 'Solutions')
@section('header_subtitle', 'Add solutions, edit their details, and manage the Solutions landing page.')
@section('content')
<div class="rounded-xl border border-slate-200 bg-white p-5">
    @if(session('status')) <p role="status" class="mb-4 text-emerald-700">{{ session('status') }}</p> @endif
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('solutions') }}" class="text-indigo-700">View public Solutions page →</a>
        <a href="{{ route('admin.solutions.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white">Add solution</a>
    </div>
        <section class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-slate-200 p-4">
            <div><h2 class="font-bold text-slate-900">Solutions landing page</h2><p class="mt-1 text-sm text-slate-500">Edit the page heading, introduction, search description and publishing status.</p></div>
            <a href="{{ route('admin.pages.edit', 'solutions') }}" class="rounded-lg border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-700">Edit landing page</a>
        </section>
    <h2 class="text-base font-bold text-slate-900">Solution details</h2>
    <div class="mt-4 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
    @foreach($solutions as $key => $details)
        <article class="flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-white">
            @include('admin.solution-image', ['details' => $details])
            <div class="flex flex-1 flex-col gap-3 p-4">
                <p class="text-xs font-semibold text-indigo-700">{{ $details['is_published'] ? 'Published' : 'Draft' }} · {{ count($details['areas']) }} support areas</p>
                <h3 class="font-bold text-slate-900">{{ $details['title'] }}</h3>
                <p class="text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($details['description'], 150) }}</p>
                <a href="{{ route('admin.solutions.edit', $key) }}" class="mt-auto rounded-lg bg-indigo-600 px-4 py-2 text-center text-sm font-semibold text-white">Edit solution<span class="sr-only">: {{ $details['title'] }}</span></a>
            </div>
        </article>
    @endforeach
    </div>
</div>
@endsection
