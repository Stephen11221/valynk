@extends('layouts.admin')

@section('title', 'Add User')
@section('header_title', 'Add User')
@section('header_subtitle', 'Create a new account and select its type')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <div class="mb-6 flex items-center justify-between gap-3">
            <div><h2 class="text-lg font-bold text-slate-900">New user account</h2><p class="text-xs text-slate-500">The user can sign in with the password you set.</p></div>
            <a href="{{ route('admin.users') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900"><i class="fa-solid fa-arrow-left mr-1"></i> Back to users</a>
        </div>
        @if($errors->any()) <p role="alert" class="mb-5 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">Please correct the fields below.</p> @endif
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <label class="block text-sm font-semibold text-slate-700">Name<input name="name" value="{{ old('name') }}" required maxlength="255" autocomplete="name" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('name') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
                <label class="block text-sm font-semibold text-slate-700">Email address<input name="email" type="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('email') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
                <label class="block text-sm font-semibold text-slate-700">Account type<select name="account_type" required class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"><option value="" disabled @selected(!old('account_type'))>Select account type</option>@foreach($accountTypes as $accountType)<option value="{{ $accountType }}" @selected(old('account_type') === $accountType)>{{ $accountType }}</option>@endforeach</select>@error('account_type') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
                <label class="block text-sm font-semibold text-slate-700">Phone number<input name="phone" value="{{ old('phone') }}" maxlength="30" autocomplete="tel" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('phone') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
                <label class="block text-sm font-semibold text-slate-700 sm:col-span-2">Location<input name="location" value="{{ old('location') }}" maxlength="100" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('location') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
            </div>
            <div class="border-t border-slate-200 pt-5"><p class="text-sm font-bold text-slate-800">Sign-in password</p><p class="mt-1 text-xs text-slate-500">Use at least 12 characters.</p><div class="mt-3 grid gap-5 sm:grid-cols-2"><label class="block text-sm font-semibold text-slate-700">Password<input name="password" type="password" minlength="12" required autocomplete="new-password" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('password') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label><label class="block text-sm font-semibold text-slate-700">Confirm password<input name="password_confirmation" type="password" minlength="12" required autocomplete="new-password" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"></label></div></div>
            <div class="flex justify-end gap-3 border-t border-slate-200 pt-5"><a href="{{ route('admin.users') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a><button type="submit" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Create user</button></div>
        </form>
    </div>
</div>
@endsection
