@extends('layouts.admin')

@section('title', 'Analytics & Reports')
@section('header_title', 'Analytics & Impact Metrics')
@section('header_subtitle', 'Comprehensive data visualization of evidence matching quality and sector outcomes')

@section('content')
<div class="space-y-6">

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase">Total System Volume</span>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ $analytics['total_volume'] }}</div>
            <p class="text-xs text-emerald-600 mt-1"><i class="fa-solid fa-arrow-trend-up"></i> +18.4% month over month</p>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase">Evidence Precision Rate</span>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ $analytics['accuracy'] }}</div>
            <p class="text-xs text-slate-400 mt-1">Clinical outcome alignment</p>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase">Avg Response Time</span>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ $analytics['avg_matching_time'] }}</div>
            <p class="text-xs text-sky-600 mt-1"><i class="fa-solid fa-bolt"></i> Real-time indexing</p>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase">Long-Term Retention</span>
            <div class="mt-2 text-2xl font-black text-slate-900">{{ $analytics['retention_rate'] }}</div>
            <p class="text-xs text-slate-400 mt-1">Sustained pairing satisfaction</p>
        </div>
    </div>

    <!-- Analytics Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Sector Impact Chart -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-base font-bold text-slate-900">Sectors & Domain Breakdown</h3>
            <p class="text-xs text-slate-500">Matching volume distributed across key clinical and educational domains</p>
            
            <div class="space-y-4 pt-2">
                @foreach($analytics['sectors'] as $sector)
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1.5">
                            <span class="text-slate-800">{{ $sector['name'] }}</span>
                            <span class="text-slate-900 font-bold">{{ $sector['percentage'] }}%</span>
                        </div>
                        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 {{ $sector['color'] }}" style="width: <?php echo $sector['percentage']; ?>%;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Outcome Metrics -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Evidence Outcome Metrics</h3>
                <p class="text-xs text-slate-500">Validation framework checkpoints</p>

                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                        <span class="text-xs text-slate-500 block">Proximity Score Index</span>
                        <span class="text-xl font-bold text-slate-900">97.4%</span>
                        <p class="text-[10px] text-slate-400 mt-1">Optimal regional placement</p>
                    </div>
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                        <span class="text-xs text-slate-500 block">Specialty Fit Index</span>
                        <span class="text-xl font-bold text-slate-900">98.9%</span>
                        <p class="text-[10px] text-slate-400 mt-1">Expert credential matching</p>
                    </div>
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                        <span class="text-xs text-slate-500 block">Institutional Compliance</span>
                        <span class="text-xl font-bold text-slate-900">100%</span>
                        <p class="text-[10px] text-slate-400 mt-1">HIPAA & FERPA verified</p>
                    </div>
                    <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                        <span class="text-xs text-slate-500 block">Family Satisfaction</span>
                        <span class="text-xl font-bold text-slate-900">4.9/5</span>
                        <p class="text-[10px] text-slate-400 mt-1">Based on 6,400+ surveys</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button class="px-4 py-2 text-xs font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded-lg shadow-sm transition-colors">
                    <i class="fa-solid fa-download"></i> Download Full PDF Report
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
