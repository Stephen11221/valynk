@extends('layouts.admin')

@section('title', $provider ? 'Edit Provider' : 'Add Provider')
@section('header_title', $provider ? 'Review Provider' : 'Add New Provider')
@section('header_subtitle', $provider ? 'Update provider details, approval and verification' : 'Create a provider account and service profile')

@section('content')
<div class="mx-auto max-w-3xl rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
    <a href="{{ route('admin.providers') }}" class="text-xs font-semibold text-indigo-700">← All Providers</a>
    <h2 class="mt-3 text-lg font-bold text-slate-900">{{ $provider?->name ?? 'New provider' }}</h2>
    @if($errors->any()) <p role="alert" class="my-4 rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">Please correct the fields below.</p> @endif
    <form method="POST" action="{{ $provider ? route('admin.providers.update', $provider) : route('admin.providers.store') }}" class="mt-5 space-y-5">
        @csrf
        @if($provider) @method('PUT') @endif
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="grid gap-1 text-sm font-semibold">Name<input name="name" value="{{ old('name', $provider?->name) }}" required maxlength="255" class="rounded-lg border border-slate-300 p-2 font-normal">@error('name') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Email<input name="email" type="email" value="{{ old('email', $provider?->email) }}" required maxlength="255" class="rounded-lg border border-slate-300 p-2 font-normal">@error('email') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Phone<input name="phone" value="{{ old('phone', $provider?->phone) }}" maxlength="30" class="rounded-lg border border-slate-300 p-2 font-normal">@error('phone') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Location<input name="location" value="{{ old('location', $provider?->location) }}" maxlength="100" class="rounded-lg border border-slate-300 p-2 font-normal">@error('location') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Business / service<input name="service" value="{{ old('service', $provider?->providerProfile?->service) }}" required maxlength="255" class="rounded-lg border border-slate-300 p-2 font-normal">@error('service') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Category<input name="category" value="{{ old('category', $provider?->providerProfile?->category) }}" required maxlength="255" placeholder="e.g. Academic Support" class="rounded-lg border border-slate-300 p-2 font-normal">@error('category') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Approval status<select name="status" required class="rounded-lg border border-slate-300 p-2 font-normal">@foreach($statuses as $status)<option value="{{ $status }}" @selected(old('status', $provider?->providerProfile?->status ?? 'Pending') === $status)>{{ $status }}</option>@endforeach</select>@error('status') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Verification<select name="verification" required class="rounded-lg border border-slate-300 p-2 font-normal">@foreach($verifications as $verification)<option value="{{ $verification }}" @selected(old('verification', $provider?->providerProfile?->verification ?? 'Not Verified') === $verification)>{{ $verification }}</option>@endforeach</select>@error('verification') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
        </div>
        <div class="border-t border-slate-200 pt-4"><p class="text-sm font-bold">{{ $provider ? 'Reset password (optional)' : 'Sign-in password' }}</p><p class="mt-1 text-xs text-slate-500">Use at least 12 characters.</p><div class="mt-3 grid gap-4 sm:grid-cols-2"><label class="grid gap-1 text-sm font-semibold">Password<input name="password" type="password" minlength="12" autocomplete="new-password" {{ $provider ? '' : 'required' }} class="rounded-lg border border-slate-300 p-2 font-normal">@error('password') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label><label class="grid gap-1 text-sm font-semibold">Confirm password<input name="password_confirmation" type="password" minlength="12" autocomplete="new-password" {{ $provider ? '' : 'required' }} class="rounded-lg border border-slate-300 p-2 font-normal"></label></div></div>
        <div class="flex justify-end gap-2 border-t border-slate-200 pt-4"><a href="{{ route('admin.providers') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold">Cancel</a><button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ $provider ? 'Save provider' : 'Add provider' }}</button></div>
    </form>
</div>
@endsection
