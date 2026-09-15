@extends('layouts.admin')

@section('title', 'Edit Page')
@section('header_title', 'Edit Page')
@section('header_subtitle', 'Changes to published pages appear on the public website.')

@section('content')
<div class="max-w-3xl rounded-xl border border-slate-200 bg-white p-5">
    <a href="{{ route('admin.content') }}" class="text-xs text-indigo-700">← All Content</a>
    <h2 class="mt-3 text-lg font-bold text-slate-900">{{ $sitePage->title }}</h2>
    @if($errors->any()) <p role="alert" class="my-3 text-sm text-rose-700">Please correct the fields below.</p> @endif
    <form method="POST" action="{{ route('admin.content.update', $sitePage) }}" class="mt-5 grid gap-4">
        @csrf
        @method('PUT')
        <label class="grid gap-1 text-sm font-semibold">Page title <input name="title" value="{{ old('title', $sitePage->title) }}" required maxlength="255" class="rounded-lg border border-slate-300 p-2 font-normal"></label>
        @error('title') <p class="text-xs text-rose-700">{{ $message }}</p> @enderror
        <label class="grid gap-1 text-sm font-semibold">Search description <textarea name="meta_description" maxlength="500" rows="2" class="rounded-lg border border-slate-300 p-2 font-normal">{{ old('meta_description', $sitePage->meta_description) }}</textarea></label>
        @error('meta_description') <p class="text-xs text-rose-700">{{ $message }}</p> @enderror
        <label class="grid gap-1 text-sm font-semibold">Eyebrow <input name="eyebrow" value="{{ old('eyebrow', data_get($sitePage, 'content.eyebrow')) }}" maxlength="255" class="rounded-lg border border-slate-300 p-2 font-normal"></label>
        <label class="grid gap-1 text-sm font-semibold">Main heading <textarea name="heading" required maxlength="500" rows="2" class="rounded-lg border border-slate-300 p-2 font-normal">{{ old('heading', data_get($sitePage, 'content.heading')) }}</textarea></label>
        @error('heading') <p class="text-xs text-rose-700">{{ $message }}</p> @enderror
        <label class="grid gap-1 text-sm font-semibold">Introduction <textarea name="intro" required maxlength="2000" rows="4" class="rounded-lg border border-slate-300 p-2 font-normal">{{ old('intro', data_get($sitePage, 'content.intro')) }}</textarea></label>
        @error('intro') <p class="text-xs text-rose-700">{{ $message }}</p> @enderror
        <label class="flex items-center gap-2 text-sm"><input type="hidden" name="is_published" value="0"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $sitePage->is_published) ? 'checked' : '' }}> Published</label>
        <button class="w-fit rounded-lg bg-indigo-600 px-5 py-2 text-sm font-semibold text-white" type="submit">Save page</button>
    </form>
</div>
@endsection
