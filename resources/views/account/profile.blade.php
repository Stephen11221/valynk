@extends('layouts.account')

@section('title', 'My Profile')

@section('content')
<div class="mx-auto max-w-3xl">
    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-indigo-700">← Dashboard</a>
    <h1 class="mt-3 text-2xl font-extrabold">My profile</h1>
    <p class="mt-1 text-sm text-slate-600">Update the details stored with your {{ $user->account_type }} account.</p>
    @if($errors->any()) <p role="alert" class="mt-5 rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">Please correct the fields below.</p> @endif
    <form method="POST" action="{{ route('account.profile.update') }}" class="mt-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        @csrf
        @method('PUT')
        <div class="grid gap-5 sm:grid-cols-2">
            <label class="grid gap-1 text-sm font-semibold">Name<input name="name" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name" class="rounded-lg border border-slate-300 p-2.5 font-normal">@error('name') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Email address<input name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="255" autocomplete="email" class="rounded-lg border border-slate-300 p-2.5 font-normal">@error('email') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Phone<input name="phone" value="{{ old('phone', $user->phone) }}" maxlength="30" autocomplete="tel" class="rounded-lg border border-slate-300 p-2.5 font-normal">@error('phone') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
            <label class="grid gap-1 text-sm font-semibold">Location<input name="location" value="{{ old('location', $user->location) }}" maxlength="100" class="rounded-lg border border-slate-300 p-2.5 font-normal">@error('location') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
        </div>
        <p class="mt-5 text-xs text-slate-500">Account type: <strong>{{ $user->account_type }}</strong>. Contact an administrator if this is incorrect.</p>

        @if($user->account_type === 'Provider')
            <div class="mt-6 border-t border-slate-200 pt-5"><h2 class="text-lg font-bold">Service details</h2><p class="mt-1 text-xs text-slate-500">Approval and verification are managed by VALYNK administrators.</p>
                <div class="mt-4 grid gap-5 sm:grid-cols-2">
                    <label class="grid gap-1 text-sm font-semibold">Service<input name="service" value="{{ old('service', $user->providerProfile?->service) }}" required maxlength="255" class="rounded-lg border border-slate-300 p-2.5 font-normal">@error('service') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
                    <label class="grid gap-1 text-sm font-semibold">Category<input name="category" value="{{ old('category', $user->providerProfile?->category) }}" required maxlength="255" class="rounded-lg border border-slate-300 p-2.5 font-normal">@error('category') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
                </div>
                <p class="mt-4 text-xs text-slate-600">Approval: <strong>{{ $user->providerProfile?->status ?? 'Pending' }}</strong> · Verification: <strong>{{ $user->providerProfile?->verification ?? 'Not Verified' }}</strong></p>
            </div>
        @endif

        <div class="mt-6 border-t border-slate-200 pt-5"><h2 class="text-lg font-bold">Account security</h2><p class="mt-1 text-xs text-slate-500">Enter your current password when changing your email or password.</p>
            <div class="mt-4 grid gap-5 sm:grid-cols-2">
                <label class="grid gap-1 text-sm font-semibold">Current password<input name="current_password" type="password" autocomplete="current-password" class="rounded-lg border border-slate-300 p-2.5 font-normal">@error('current_password') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
                <span class="hidden sm:block"></span>
                <label class="grid gap-1 text-sm font-semibold">New password <span class="text-xs font-normal text-slate-500">(optional, at least 12 characters)</span><input name="password" type="password" minlength="12" autocomplete="new-password" class="rounded-lg border border-slate-300 p-2.5 font-normal">@error('password') <span class="text-xs text-rose-700">{{ $message }}</span> @enderror</label>
                <label class="grid gap-1 text-sm font-semibold">Confirm new password<input name="password_confirmation" type="password" minlength="12" autocomplete="new-password" class="rounded-lg border border-slate-300 p-2.5 font-normal"></label>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3 border-t border-slate-200 pt-5"><a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold">Cancel</a><button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">Save profile</button></div>
    </form>
</div>
@endsection
