@extends('layouts.admin')

@section('title', 'Content Management')
@section('header_title', 'Content Management')
@section('header_subtitle', 'Edit the public pages visitors see.')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-5">
    @if(session('status')) <p role="status" class="mb-4 text-emerald-700">{{ session('status') }}</p> @endif
    <a href="{{ route('admin.solutions.index') }}" class="mb-4 inline-block rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Manage solution popups</a>
    <h2 class="text-base font-bold text-slate-900">All Content</h2>
    <p class="text-xs text-slate-500 mb-5">These pages are loaded from the site_pages table.</p>
    @forelse($pages as $page)
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 py-4">
            <div>
                <p class="font-semibold text-slate-900">{{ $page->title }}</p>
                <p class="text-xs text-slate-500">/{{ $page->slug === 'home' ? '' : $page->slug }} · {{ $page->is_published ? 'Published' : 'Draft' }} · Updated {{ $page->updated_at->diffForHumans() }}</p>
            </div>
            <a href="{{ route('admin.content.edit', $page) }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-xs font-semibold text-white">Edit page</a>
        </div>
    @empty
        <p class="border-t border-slate-100 pt-4 text-sm text-slate-500">No pages yet. Run the site page seeder to create the public pages.</p>
    @endforelse
</div>
@endsection
