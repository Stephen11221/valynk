@extends('layouts.admin')
@section('title', $solution ? 'Edit Solution' : 'Add Solution')
@section('header_title', $solution ? 'Edit Solution' : 'Add Solution')
@section('header_subtitle', 'Saved published content appears immediately on the Solutions page.')
@section('content')
<div class="max-w-5xl rounded-xl border border-slate-200 bg-white p-5">
    <a href="{{ route('admin.solutions.index') }}" class="text-sm text-indigo-700">← All solutions</a>
    @if($errors->any())
        <div role="alert" class="my-4 rounded-lg bg-rose-50 p-4 text-sm text-rose-700"><p class="font-bold">Please correct the following:</p><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ $solution ? route('admin.solutions.update', $solution) : route('admin.solutions.store') }}" class="mt-5 grid gap-5" id="solution-editor">
        @csrf
        @if($solution) @method('PUT') @endif
        @foreach(['title' => ['Solution title', 180], 'description' => ['Card and popup introduction', 1000], 'tagline' => ['Hero tagline (optional)', 150], 'age_range' => ['Age range and stage', 150], 'support_intro' => ['Support areas introduction', 500], 'image_url' => ['Hero and card image URL (HTTPS, optional)', 2000]] as $field => [$label, $maximum])
            <label class="grid gap-1 text-sm font-semibold">{{ $label }}
                <input name="{{ $field }}" value="{{ old($field, $details[$field] ?? '') }}" maxlength="{{ $maximum }}" type="{{ $field === 'image_url' ? 'url' : 'text' }}" @required(!in_array($field, ['tagline', 'image_url'])) class="w-full rounded-lg border border-slate-300 p-2 font-normal">
            </label>
        @endforeach
        <div class="grid gap-5 sm:grid-cols-2">
            <label class="grid gap-1 text-sm font-semibold">Accent colour<select name="tone" class="rounded-lg border border-slate-300 p-2 font-normal">@foreach(['pink', 'blue', 'green', 'gold', 'purple', 'teal', 'orange'] as $tone)<option value="{{ $tone }}" @selected(old('tone', $details['tone'] ?? 'pink') === $tone)>{{ ucfirst($tone) }}</option>@endforeach</select></label>
            <label class="grid gap-1 text-sm font-semibold">Default photo (used when no URL is set)<select name="photo" class="rounded-lg border border-slate-300 p-2 font-normal">@foreach(['Confidence', 'Learning', 'Discovery', 'Talent', 'Leadership', 'Wellbeing', 'Digital skills', 'Specialist support'] as $index => $label)<option value="{{ $index }}" @selected((int) old('photo', $details['photo'] ?? 0) === $index)>{{ $label }}</option>@endforeach</select></label>
        </div>
        @foreach(['highlights' => ['Hero highlights — up to 4, one per line', 1000], 'benefits' => ['Key benefits — up to 10, one per line', 3000]] as $field => [$label, $maximum])
            <label class="grid gap-1 text-sm font-semibold">{{ $label }}<textarea name="{{ $field }}" required rows="5" maxlength="{{ $maximum }}" class="rounded-lg border border-slate-300 p-2 font-normal">{{ old($field, implode("\n", $details[$field] ?? [])) }}</textarea></label>
        @endforeach
        <section aria-labelledby="support-editor-title">
            <h2 id="support-editor-title" class="text-lg font-bold">Key areas of support</h2><p class="mb-4 text-sm text-slate-500">Add between 1 and 8 areas. Each area can have up to 8 points.</p>
            <div id="support-areas" class="grid gap-4">
                @foreach(old('areas', $details['areas'] ?? [['title' => '', 'points' => []]]) as $index => $area)
                    <fieldset class="support-area rounded-lg border border-slate-200 p-4" data-area-index="{{ $index }}">
                        <legend class="px-2 font-semibold">Support area</legend>
                        <label class="mb-3 grid gap-1 text-sm">Title<input name="areas[{{ $index }}][title]" value="{{ $area['title'] ?? '' }}" required maxlength="180" class="rounded-lg border border-slate-300 p-2"></label>
                        <label class="mb-3 grid gap-1 text-sm">Points (one per line)<textarea name="areas[{{ $index }}][points]" required rows="4" maxlength="2000" class="rounded-lg border border-slate-300 p-2">{{ is_array($area['points'] ?? []) ? implode("\n", $area['points'] ?? []) : $area['points'] }}</textarea></label>
                        <label class="mb-3 grid gap-1 text-sm">Image URL (HTTPS, optional)<input name="areas[{{ $index }}][image_url]" type="url" value="{{ $area['image_url'] ?? '' }}" maxlength="2000" class="rounded-lg border border-slate-300 p-2"></label>
                        <button type="button" data-remove-area class="text-sm font-semibold text-rose-700">Remove area</button>
                    </fieldset>
                @endforeach
            </div>
            <button type="button" id="add-support-area" class="mt-3 rounded-lg border border-indigo-200 px-4 py-2 text-sm font-semibold text-indigo-700">+ Add support area</button>
            <p id="support-area-status" role="status" class="mt-2 text-sm text-slate-500"></p>
        </section>
        <div class="grid gap-5 sm:grid-cols-2">
            <label class="grid gap-1 text-sm font-semibold">Button label<input name="cta_label" value="{{ old('cta_label', $details['cta_label'] ?? 'Get Connected') }}" required maxlength="80" class="rounded-lg border border-slate-300 p-2 font-normal"></label>
            <label class="grid gap-1 text-sm font-semibold">Button destination<select name="cta_route" class="rounded-lg border border-slate-300 p-2 font-normal">@foreach(['contact' => 'Contact team', 'register' => 'Create an account', 'development.landing' => 'Performance and confidence programme', 'development.register' => 'Register a child'] as $route => $label)<option value="{{ $route }}" @selected(old('cta_route', $details['cta_route'] ?? 'contact') === $route)>{{ $label }}</option>@endforeach</select></label>
        </div>
        <label class="flex items-center gap-2"><input type="hidden" name="is_published" value="0"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $details['is_published'] ?? false))> Published on the Solutions page</label>
        <button type="submit" class="w-fit rounded-lg bg-indigo-600 px-5 py-3 font-semibold text-white">Save solution</button>
    </form>
</div>
<script src="{{ asset('js/admin-solutions.js') }}?v={{ filemtime(public_path('js/admin-solutions.js')) }}" defer></script>
@endsection
