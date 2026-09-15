@extends('layouts.admin')

@section('title', 'Edit User')
@section('header_title', 'Edit User Account')
@section('header_subtitle', 'Update account details, type, and access credentials')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <div class="mb-6 flex items-center justify-between"><div><p class="text-sm font-bold text-slate-900">{{ $user->name }}</p><p class="text-xs text-slate-500">{{ $user->email }}</p></div><a href="{{ route('admin.users') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900"><i class="fa-solid fa-arrow-left mr-1"></i> Back to users</a></div>
        <p class="mb-5 text-xs text-slate-500">Choosing Admin grants full administrator access. Changing an admin to another type removes that access.</p>
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid gap-5 sm:grid-cols-2">
                <label class="block text-sm font-semibold text-slate-700">Name<input name="name" value="{{ old('name', $user->name) }}" required class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('name') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
                <label class="block text-sm font-semibold text-slate-700">Email address<input name="email" type="email" value="{{ old('email', $user->email) }}" required class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('email') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
                <label class="block text-sm font-semibold text-slate-700">Account type<select name="account_type" required class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@foreach($accountTypes as $accountType)<option value="{{ $accountType }}" @selected(old('account_type', $user->account_type) === $accountType)>{{ $accountType }}</option>@endforeach</select>@error('account_type') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
                <label class="block text-sm font-semibold text-slate-700">Phone number<input name="phone" value="{{ old('phone', $user->phone) }}" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('phone') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
                <label class="block text-sm font-semibold text-slate-700 sm:col-span-2">Location<input name="location" value="{{ old('location', $user->location) }}" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('location') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label>
            </div>
            <div class="border-t border-slate-200 pt-5"><p class="text-sm font-bold text-slate-800">Reset password <span class="font-normal text-slate-500">(optional)</span></p><div class="mt-3 grid gap-5 sm:grid-cols-2"><label class="block text-sm font-semibold text-slate-700">New password<input name="password" type="password" autocomplete="new-password" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">@error('password') <span class="mt-1 block text-xs text-rose-600">{{ $message }}</span> @enderror</label><label class="block text-sm font-semibold text-slate-700">Confirm new password<input name="password_confirmation" type="password" autocomplete="new-password" class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"></label></div></div>
            <div class="flex justify-end gap-3 border-t border-slate-200 pt-5"><a href="{{ route('admin.users') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a><button type="submit" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Save changes</button></div>
        </form>
    </div>
</div>
@endsection
