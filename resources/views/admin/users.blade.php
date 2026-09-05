@extends('layouts.admin')

@section('title', 'User Management')
@section('header_title', 'User & Entity Management')
@section('header_subtitle', 'Manage registered Families, Providers, Institutions, and system permissions')

@section('content')
<div class="space-y-6">

    <!-- Header Actions & Filters -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        
        <!-- Filter Tabs -->
        <div class="flex items-center gap-1 overflow-x-auto pb-1 sm:pb-0">
            <a href="{{ route('admin.users', ['role' => 'all', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $currentRole === 'all' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                All Users (8)
            </a>
            <a href="{{ route('admin.users', ['role' => 'family', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $currentRole === 'family' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Families
            </a>
            <a href="{{ route('admin.users', ['role' => 'provider', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $currentRole === 'provider' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Providers
            </a>
            <a href="{{ route('admin.users', ['role' => 'institution', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $currentRole === 'institution' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Institutions
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-2">
            <input type="hidden" name="role" value="{{ $currentRole }}">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..." class="pl-8 pr-3 py-1.5 text-xs bg-slate-50 border border-slate-300 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 w-48 sm:w-64">
            </div>
            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded-lg transition-colors">
                Filter
            </button>
            @if($search)
                <a href="{{ route('admin.users', ['role' => $currentRole]) }}" class="text-xs text-slate-500 hover:text-slate-700">Clear</a>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">User / Entity Name</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4">Category / Specialty</th>
                        <th class="py-3 px-4">Verification Status</th>
                        <th class="py-3 px-4 text-center">Active Matches</th>
                        <th class="py-3 px-4 text-center">Rating</th>
                        <th class="py-3 px-4">Joined Date</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $user['name'] }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $user['email'] }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($user['role'] === 'Provider')
                                    <span class="px-2 py-0.5 rounded-full font-bold text-[11px] bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <i class="fa-solid fa-user-doctor"></i> Provider
                                    </span>
                                @elseif($user['role'] === 'Family')
                                    <span class="px-2 py-0.5 rounded-full font-bold text-[11px] bg-sky-50 text-sky-700 border border-sky-200">
                                        <i class="fa-solid fa-house-chimney-user"></i> Family
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full font-bold text-[11px] bg-purple-50 text-purple-700 border border-purple-200">
                                        <i class="fa-solid fa-building-columns"></i> Institution
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-600">{{ $user['category'] }}</td>
                            <td class="py-3.5 px-4">
                                @if(str_contains(strtolower($user['status']), 'verified'))
                                    <span class="inline-flex items-center gap-1 text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full text-[11px] font-bold">
                                        <i class="fa-solid fa-circle-check"></i> {{ $user['status'] }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full text-[11px] font-bold">
                                        <i class="fa-solid fa-clock"></i> {{ $user['status'] }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-slate-800">{{ $user['matches_count'] }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center gap-1 text-amber-600 font-bold">
                                    <i class="fa-solid fa-star text-xs"></i> {{ $user['rating'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-mono">{{ $user['joined'] }}</td>
                            <td class="py-3.5 px-4 text-right space-x-1">
                                <button class="p-1.5 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded transition-colors" title="View Profile">
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>
                                <button class="p-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors" title="Edit Permissions">
                                    <i class="fa-solid fa-pen text-sm"></i>
                                </button>
                                <button class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded transition-colors" title="Suspend User">
                                    <i class="fa-solid fa-ban text-sm"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">
                                <i class="fa-solid fa-user-slash text-2xl mb-2 block"></i>
                                No users found matching your search criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-200 text-xs text-slate-500 flex justify-between items-center">
            <span>Showing {{ $users->count() }} records</span>
            <span class="font-medium text-slate-600">Verification Engine Standard v2.4</span>
        </div>
    </div>

</div>
@endsection
