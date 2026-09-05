@extends('layouts.admin')

@section('title', 'Platform Settings')
@section('header_title', 'Platform Configuration & Algorithm Weights')
@section('header_subtitle', 'Adjust evidence-matching thresholds, security settings, and notifications')

@section('content')
<div class="space-y-6 max-w-5xl">

    <!-- Settings Card 1: Matching Algorithm Engine -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Matching Engine Weight Configuration</h3>
                <p class="text-xs text-slate-500">Fine-tune evidence-backed scoring algorithm parameters</p>
            </div>
            <span class="text-xs font-mono font-bold text-sky-600 bg-sky-50 px-2.5 py-1 rounded-md">
                Algorithm v3.8.2
            </span>
        </div>

        <div class="space-y-4 pt-2">
            <div>
                <div class="flex justify-between text-xs font-semibold mb-1">
                    <label class="text-slate-800">Specialist Credential Weight</label>
                    <span class="text-sky-600">40%</span>
                </div>
                <input type="range" min="10" max="70" value="40" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer">
            </div>

            <div>
                <div class="flex justify-between text-xs font-semibold mb-1">
                    <label class="text-slate-800">Geographic Proximity Weight</label>
                    <span class="text-sky-600">25%</span>
                </div>
                <input type="range" min="10" max="50" value="25" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer">
            </div>

            <div>
                <div class="flex justify-between text-xs font-semibold mb-1">
                    <label class="text-slate-800">Clinical Outcome Evidence</label>
                    <span class="text-sky-600">20%</span>
                </div>
                <input type="range" min="10" max="50" value="20" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer">
            </div>

            <div>
                <div class="flex justify-between text-xs font-semibold mb-1">
                    <label class="text-slate-800">Insurance & Budget Compatibility</label>
                    <span class="text-sky-600">15%</span>
                </div>
                <input type="range" min="5" max="30" value="15" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer">
            </div>
        </div>
    </div>

    <!-- Settings Card 2: Security & Compliance -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <div class="border-b border-slate-100 pb-4">
            <h3 class="text-base font-bold text-slate-900">Security & Compliance Safeguards</h3>
            <p class="text-xs text-slate-500">Manage data protection standards, multi-factor policies, and audit logs</p>
        </div>

        <div class="space-y-3 pt-2">
            <label class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-slate-200 cursor-pointer hover:bg-slate-100/70 transition-colors">
                <div>
                    <span class="text-xs font-bold text-slate-800 block">Strict Verification Mandate</span>
                    <span class="text-[11px] text-slate-500">Require double-verification before making provider listings active.</span>
                </div>
                <input type="checkbox" checked class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
            </label>

            <label class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-slate-200 cursor-pointer hover:bg-slate-100/70 transition-colors">
                <div>
                    <span class="text-xs font-bold text-slate-800 block">Automated Clinical Outcome Audits</span>
                    <span class="text-[11px] text-slate-500">Run weekly automated checks on match satisfaction scores.</span>
                </div>
                <input type="checkbox" checked class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
            </label>

            <label class="flex items-center justify-between p-3 rounded-lg bg-slate-50 border border-slate-200 cursor-pointer hover:bg-slate-100/70 transition-colors">
                <div>
                    <span class="text-xs font-bold text-slate-800 block">Encrypted Audit Logging</span>
                    <span class="text-[11px] text-slate-500">Log every match view and recommendation change in immutable store.</span>
                </div>
                <input type="checkbox" checked class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
            </label>
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end gap-3">
        <button class="px-4 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
            Reset Defaults
        </button>
        <button class="px-5 py-2 text-xs font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded-lg shadow-sm transition-colors">
            Save Changes
        </button>
    </div>

</div>
@endsection
