@extends('layouts.admin')

@section('title', 'Reports & Analytics')
@section('header_title', 'Reports & Analytics')
@section('header_subtitle', 'Track platform performance, engagement, and outcome quality across the network.')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($stats as $stat)
            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-500">{{ $stat['title'] }}</span>
                    <div class="w-8 h-8 rounded-lg {{ $stat['color'] }} flex items-center justify-center">
                        <i class="fa-solid {{ $stat['icon'] }} text-xs"></i>
                    </div>
                </div>
                <div class="mt-2 text-2xl font-black text-slate-900">{{ $stat['value'] }}</div>
                <div class="mt-1 flex items-center gap-1 text-[10px] font-semibold {{ $stat['positive'] ? 'text-emerald-600' : 'text-rose-600' }}">
                    <i class="fa-solid {{ $stat['positive'] ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[9px]"></i>
                    <span>{{ $stat['change'] }}</span>
                </div>
                <div class="mt-3 pt-2 border-t border-slate-100">
                    <svg class="w-full h-7" viewBox="0 0 100 30" preserveAspectRatio="none">
                        @php
                            $max = max($stat['sparkline']);
                            $min = min($stat['sparkline']);
                            $range = $max - $min ?: 1;
                            $points = [];
                            foreach ($stat['sparkline'] as $index => $value) {
                                $x = ($index / (count($stat['sparkline']) - 1)) * 100;
                                $y = 30 - (($value - $min) / $range) * 24;
                                $points[] = $x . ',' . $y;
                            }
                        @endphp
                        <polyline fill="none" stroke="#6366F1" stroke-width="2" points="{{ implode(' ', $points) }}" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        <div class="xl:col-span-7 bg-white rounded-xl border border-slate-200/80 shadow-2xs p-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Platform Overview</h3>
                    <p class="text-[11px] text-slate-500">User activity, pairing success and revenue performance</p>
                </div>
                <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    <i class="fa-solid fa-download"></i> Export Report
                </button>
            </div>

            <div class="mt-5">
                <svg class="w-full h-60" viewBox="0 0 600 220" preserveAspectRatio="none">
                    <line x1="0" y1="180" x2="600" y2="180" stroke="#E2E8F0" />
                    <line x1="0" y1="140" x2="600" y2="140" stroke="#E2E8F0" />
                    <line x1="0" y1="100" x2="600" y2="100" stroke="#E2E8F0" />
                    <line x1="0" y1="60" x2="600" y2="60" stroke="#E2E8F0" />
                    <path d="M 0 150 C 60 120, 120 100, 180 110 S 300 80, 360 70 S 480 85, 600 50" fill="none" stroke="#8B5CF6" stroke-width="3" />
                    <path d="M 0 160 C 70 150, 150 120, 210 110 S 330 90, 420 80 S 520 60, 600 45" fill="none" stroke="#10B981" stroke-width="3" />
                    <path d="M 0 170 C 80 165, 160 155, 230 145 S 350 120, 420 100 S 520 92, 600 70" fill="none" stroke="#F59E0B" stroke-width="3" />
                </svg>
            </div>

            <div class="mt-3 flex items-center justify-between text-[10px] text-slate-400">
                <span>Jan</span>
                <span>Feb</span>
                <span>Mar</span>
                <span>Apr</span>
                <span>May</span>
                <span>Jun</span>
                <span>Jul</span>
            </div>
        </div>

        <div class="xl:col-span-5 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-2xs p-5">
                <h3 class="text-base font-bold text-slate-900">Audience Mix</h3>
                <div class="mt-4 flex items-center justify-center">
                    <div class="relative h-40 w-40 rounded-full bg-[conic-gradient(#8B5CF6_0_42%,#10B981_42%_71%,#F59E0B_71%_88%,#0EA5E9_88%_100%)]">
                        <div class="absolute inset-[22%] rounded-full bg-white"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-center">
                            <div>
                                <div class="text-xl font-black text-slate-900">88%</div>
                                <div class="text-[10px] text-slate-500">Conversion</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 space-y-2 text-[11px]">
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-violet-500"></span><span class="text-slate-600">Families</span></div><span class="font-bold text-slate-800">42%</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span><span class="text-slate-600">Providers</span></div><span class="font-bold text-slate-800">29%</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span><span class="text-slate-600">Institutions</span></div><span class="font-bold text-slate-800">17%</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span><span class="text-slate-600">Partners</span></div><span class="font-bold text-slate-800">12%</span></div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200/80 shadow-2xs p-5">
                <h3 class="text-base font-bold text-slate-900">Segment Performance</h3>
                <div class="mt-4 space-y-3">
                    @foreach($performance as $entry)
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="text-slate-700 font-semibold">{{ $entry['segment'] }}</span>
                                <span class="text-slate-500">{{ number_format($entry['matches']) }} matches</span>
                            </div>
                            <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-emerald-500" style="width: {{ min(($entry['matches'] / 2000) * 100, 100) }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
