@extends('layouts.admin')

@section('title', 'Evidence Matches')
@section('header_title', 'Evidence-Backed Matching Ledger')
@section('header_subtitle', 'Audit clinical and specialized matching factors, algorithms, and active connections')

@section('content')
<div class="space-y-6">

    <!-- Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-1">
            <a href="{{ route('admin.matches', ['status' => 'all']) }}" 
               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $currentStatus === 'all' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                All Matches
            </a>
            <a href="{{ route('admin.matches', ['status' => 'active']) }}" 
               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $currentStatus === 'active' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Active
            </a>
            <a href="{{ route('admin.matches', ['status' => 'pending_review']) }}" 
               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $currentStatus === 'pending_review' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Pending Review
            </a>
            <a href="{{ route('admin.matches', ['status' => 'completed']) }}" 
               class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-colors {{ $currentStatus === 'completed' ? 'bg-sky-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Completed
            </a>
        </div>

        <button class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded-lg transition-colors">
            <i class="fa-solid fa-arrows-rotate"></i> Re-run Matching Algorithm
        </button>
    </div>

    <!-- Matches Cards List -->
    <div class="space-y-4">
        @foreach($matches as $match)
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    <!-- Left info -->
                    <div class="flex-1 space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-xs font-extrabold text-sky-700 bg-sky-50 border border-sky-200 px-2.5 py-1 rounded-md">
                                {{ $match['id'] }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400">Created {{ $match['created_at'] }}</span>
                            @if($match['status'] === 'Active')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Active</span>
                            @elseif($match['status'] === 'Pending Review')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">Pending Audit</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Completed</span>
                            @endif
                        </div>

                        <!-- Match Pair Info -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Family / Recipient</span>
                                <p class="text-sm font-bold text-slate-900">{{ $match['family'] }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Specialist / Provider</span>
                                <p class="text-sm font-bold text-indigo-900">{{ $match['provider'] }}</p>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Affiliated Institution</span>
                                <p class="text-sm font-semibold text-slate-700">{{ $match['institution'] }}</p>
                            </div>
                        </div>

                        <!-- Evidence Factors -->
                        <div class="pt-2">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Evidence-Backed Verification Markers</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($match['evidence_factors'] as $factor)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-600 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-md">
                                        <i class="fa-solid fa-check text-emerald-500"></i> {{ $factor }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Right Match Score Widget -->
                    <div class="flex lg:flex-col items-center lg:items-end justify-between border-t lg:border-t-0 lg:border-l border-slate-100 pt-4 lg:pt-0 lg:pl-6 shrink-0">
                        <div class="text-center lg:text-right">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Match Confidence</span>
                            <span class="text-3xl font-black text-emerald-600">{{ $match['match_score'] }}%</span>
                        </div>
                        <div class="flex items-center gap-2 mt-2">
                            <button class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                View Full Audit
                            </button>
                            <button class="px-3 py-1.5 text-xs font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded-lg transition-colors">
                                Manage
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
