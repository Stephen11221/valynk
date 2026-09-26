@extends('layouts.admin')
@section('title', 'Solutions')
@section('header_title', 'Solutions')
@section('header_subtitle', 'Manage the cards and detail popups on the public Solutions page.')
@section('content')
<div class="rounded-xl border border-slate-200 bg-white p-5">
    @if(session('status')) <p role="status" class="mb-4 text-emerald-700">{{ session('status') }}</p> @endif
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('solutions') }}" class="text-indigo-700">View public Solutions page →</a>
        <a href="{{ route('admin.solutions.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white">Add solution</a>
    </div>
    @foreach($solutions as $key => $details)
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 py-4">
            <div><h2 class="font-bold text-slate-900">{{ $details['title'] }}</h2><p class="mt-1 text-sm text-slate-500">{{ $details['is_published'] ? 'Published' : 'Draft' }} · {{ count($details['areas']) }} support areas</p></div>
            <a href="{{ route('admin.solutions.edit', $key) }}" class="rounded-lg border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-700">Edit details</a>
        </div>
    @endforeach
</div>
@endsection
