@extends('layouts.admin')

@section('title', 'Content Management')
@section('header_title', 'Content Management')
@section('header_subtitle', 'Edit the public pages visitors see.')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-5">
    @if(session('status')) <p role="status" class="mb-4 text-emerald-700">{{ session('status') }}</p> @endif
    <h2 class="text-base font-bold text-slate-900">All Content</h2>
    <p class="text-xs text-slate-500 mb-5">Manage your website pages. Solution content is managed separately under Solutions.</p>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
    @foreach($pages as $page)
        <article class="flex flex-col gap-3 rounded-xl border border-slate-200 p-5">
            <h3 class="text-lg font-bold text-slate-900">{{ \Illuminate\Support\Str::headline($page->slug) }}</h3>
            <p class="text-sm text-slate-600">{{ $page->title }}</p>
            <p class="text-xs text-slate-500">/{{ $page->slug === 'home' ? '' : $page->slug }} · {{ $page->exists ? ($page->is_published ? 'Published' : 'Draft') : 'Default content' }}</p>
            <div class="mt-auto flex flex-wrap gap-3">
                <a href="{{ route('admin.pages.edit', $page->slug) }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Edit {{ \Illuminate\Support\Str::headline($page->slug) }}</a>
                <a href="{{ route($page->slug) }}" target="_blank" rel="noopener" class="px-3 py-2 text-sm text-indigo-700">View page ↗</a>
            </div>
        </article>
    @endforeach
    </div>
</div>
@endsection
