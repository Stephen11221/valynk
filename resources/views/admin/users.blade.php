@extends('layouts.admin')

@section('title', 'Account Management')
@section('header_title', 'Accounts')
@section('header_subtitle', 'Manage Individual, Family, Provider, Institution, Partner, and Admin accounts')

@section('content')
<div class="space-y-6">
    @if(session('status'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between gap-3">
        <p class="text-sm text-slate-500">Create and manage registered accounts.</p>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700"><i class="fa-solid fa-user-plus"></i> Add user</a>
    </div>

    <div class="flex flex-col gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-1 overflow-x-auto pb-1 sm:pb-0">
            @foreach(['all' => 'All users', 'individual' => 'Individuals', 'family' => 'Families', 'provider' => 'Providers', 'institution' => 'Institutions', 'admin' => 'Admins'] as $role => $label)
                <a href="{{ route('admin.users', ['role' => $role, 'search' => $search]) }}"
                   class="whitespace-nowrap rounded-lg px-3.5 py-1.5 text-xs font-semibold transition-colors {{ $currentRole === $role ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $label }}@if($role !== 'all') ({{ $accountCounts[ucfirst($role)] ?? 0 }})@endif
                </a>
            @endforeach
        </div>

        <form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-2">
            <input type="hidden" name="role" value="{{ $currentRole }}">
            <label class="relative">
                <span class="sr-only">Search users</span>
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                <input type="search" name="search" value="{{ $search }}" placeholder="Search name, email, or phone..." class="w-52 rounded-lg border border-slate-300 bg-slate-50 py-1.5 pl-8 pr-3 text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 sm:w-64">
            </label>
            <button type="submit" class="rounded-lg bg-slate-800 px-3 py-1.5 text-xs font-semibold text-white transition-colors hover:bg-slate-900">Filter</button>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-slate-200 bg-slate-50 font-semibold text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Account type</th>
                        <th class="px-4 py-3">Contact details</th>
                        <th class="px-4 py-3">Location</th>
                        <th class="px-4 py-3">Joined</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $user)
                        <tr class="transition-colors hover:bg-slate-50/80">
                            <td class="px-4 py-3.5"><div class="text-sm font-bold text-slate-900">{{ $user->name }}</div><div class="font-mono text-[11px] text-slate-400">{{ $user->email }}</div></td>
                            <td class="px-4 py-3.5"><span class="inline-flex rounded-full border border-sky-200 bg-sky-50 px-2 py-0.5 text-[11px] font-bold text-sky-700">{{ $user->account_type }}</span></td>
                            <td class="px-4 py-3.5 text-slate-600">{{ $user->phone ?: '—' }}</td>
                            <td class="px-4 py-3.5 text-slate-600">{{ $user->location ?: '—' }}</td>
                            <td class="px-4 py-3.5 font-mono text-slate-500">{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                            <td class="px-4 py-3.5 text-right"><a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-2.5 py-1.5 font-semibold text-indigo-700 transition-colors hover:bg-indigo-100"><i class="fa-solid fa-pen"></i> Edit user</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400"><i class="fa-solid fa-user-slash mb-2 block text-2xl"></i>No registered users match this filter.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between border-t border-slate-200 bg-slate-50 p-4 text-xs text-slate-500"><span>Showing {{ $users->count() }} registered accounts</span><span class="font-medium text-slate-600">Changes are saved immediately</span></div>
    </div>
</div>
@endsection
