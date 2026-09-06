@extends('layouts.admin')

@section('title', 'Overview')
@section('header_title', 'Overview')
@section('header_subtitle', "Welcome back, Admin! Here's what's happening on VALYNK today.")

@section('content')
<div class="space-y-6">

    <!-- Row 1: 6 KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        @foreach($kpis as $kpi)
            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-sm transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-semibold text-slate-500">{{ $kpi['title'] }}</span>
                        <div class="w-7 h-7 rounded-lg {{ $kpi['bg'] }} flex items-center justify-center shrink-0">
                            <i class="fa-solid {{ $kpi['icon'] }} text-xs"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-xl font-extrabold text-slate-900 leading-tight">
                        {{ $kpi['value'] }}
                    </div>
                    <div class="mt-1 flex items-center gap-1 text-[10px] font-semibold text-emerald-600">
                        <i class="fa-solid fa-arrow-up text-[9px]"></i>
                        <span>{{ $kpi['growth'] }}</span>
                    </div>
                </div>

                <!-- Sparkline SVG -->
                <div class="mt-3 pt-2 border-t border-slate-50">
                    <svg class="w-full h-7 overflow-visible" viewBox="0 0 100 30" preserveAspectRatio="none">
                        @php
                            $max = max($kpi['sparkline']);
                            $min = min($kpi['sparkline']);
                            $range = ($max - $min) ?: 1;
                            $points = [];
                            foreach($kpi['sparkline'] as $i => $v) {
                                $x = ($i / (count($kpi['sparkline']) - 1)) * 100;
                                $y = 30 - (($v - $min) / $range) * 24;
                                $points[] = "$x,$y";
                            }
                            $pointsStr = implode(' ', $points);
                        @endphp
                        <polyline fill="none" stroke="{{ $kpi['chart_color'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" points="{{ $pointsStr }}" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Row 2: Middle Charts & Activity (3 Cards Grid: 6 cols, 3 cols, 3 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Platform Activity (6 Cols) -->
        <div class="lg:col-span-6 bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Platform Activity</h3>
                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer">
                    <span>Last 30 Days</span>
                    <i class="fa-solid fa-chevron-down text-[9px] text-slate-400"></i>
                </div>
            </div>

            <!-- Legend -->
            <div class="flex items-center gap-4 mt-3 text-xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-600 inline-block"></span>
                    <span class="text-slate-600 font-medium text-[11px]">Users</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                    <span class="text-slate-600 font-medium text-[11px]">Matches</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 inline-block"></span>
                    <span class="text-slate-600 font-medium text-[11px]">Transactions</span>
                </div>
            </div>

            <!-- Multi-line SVG Graph -->
            <div class="my-4 relative h-48">
                <svg class="w-full h-full overflow-visible" viewBox="0 0 500 160" preserveAspectRatio="none">
                    <!-- Grid Lines -->
                    <line x1="0" y1="20" x2="500" y2="20" stroke="#F1F5F9" stroke-width="1" />
                    <line x1="0" y1="60" x2="500" y2="60" stroke="#F1F5F9" stroke-width="1" />
                    <line x1="0" y1="100" x2="500" y2="100" stroke="#F1F5F9" stroke-width="1" />
                    <line x1="0" y1="140" x2="500" y2="140" stroke="#F1F5F9" stroke-width="1" />

                    <!-- Area fill under purple line -->
                    <path d="M 0,100 Q 70,80 140,40 T 280,60 T 420,20 L 500,10 L 500,150 L 0,150 Z" fill="#8B5CF6" fill-opacity="0.08" />

                    <!-- Users Line (Purple) -->
                    <path d="M 0,100 C 60,90 100,50 140,40 C 180,80 220,40 280,60 C 340,30 400,20 500,10" fill="none" stroke="#8B5CF6" stroke-width="2.5" />

                    <!-- Matches Line (Green) -->
                    <path d="M 0,120 C 60,110 100,90 140,80 C 180,95 220,70 280,90 C 340,75 400,60 500,50" fill="none" stroke="#10B981" stroke-width="2.5" />

                    <!-- Transactions Line (Amber) -->
                    <path d="M 0,140 C 60,135 100,130 140,120 C 180,125 220,110 280,125 C 340,115 400,110 500,100" fill="none" stroke="#F59E0B" stroke-width="2.5" />
                </svg>
            </div>

            <!-- X-Axis Labels -->
            <div class="flex items-center justify-between text-[10px] text-slate-400 border-t border-slate-100 pt-2 font-medium">
                <span>28 Apr</span>
                <span>2 May</span>
                <span>6 May</span>
                <span>10 May</span>
                <span>14 May</span>
                <span>18 May</span>
                <span>22 May</span>
                <span>26 May</span>
            </div>
        </div>

        <!-- Matches Overview Donut Chart (3 Cols) -->
        <div class="lg:col-span-3 bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Matches Overview</h3>

            <!-- Donut SVG with center text -->
            <div class="my-3 flex items-center justify-center relative">
                <svg class="w-36 h-36 transform -rotate-90" viewBox="0 0 36 36">
                    <!-- Donut segments using stroke-dasharray -->
                    <!-- Circle 1: Completed 52.6% (emerald) -->
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="#10B981" stroke-width="4" stroke-dasharray="52.6 47.4" stroke-dashoffset="0" />
                    <!-- Circle 2: In Progress 30.2% (sky) -->
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="#0EA5E9" stroke-width="4" stroke-dasharray="30.2 69.8" stroke-dashoffset="-52.6" />
                    <!-- Circle 3: Pending 10.7% (amber) -->
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="#F59E0B" stroke-width="4" stroke-dasharray="10.7 89.3" stroke-dashoffset="-82.8" />
                    <!-- Circle 4: Cancelled 6.5% (rose) -->
                    <circle cx="18" cy="18" r="15.915" fill="none" stroke="#EF4444" stroke-width="4" stroke-dasharray="6.5 93.5" stroke-dashoffset="-93.5" />
                </svg>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                    <span class="text-base font-black text-slate-900 leading-none">{{ $matchesOverview['total'] }}</span>
                    <span class="text-[9px] font-semibold text-slate-400 mt-0.5">Total Matches</span>
                </div>
            </div>

            <!-- Donut Legend List -->
            <div class="space-y-1.5 text-[11px] pt-1 border-t border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-slate-600 font-medium">Completed</span>
                    </div>
                    <span class="font-bold text-slate-800">{{ $matchesOverview['completed']['count'] }} ({{ $matchesOverview['completed']['percent'] }})</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span class="text-slate-600 font-medium">In Progress</span>
                    </div>
                    <span class="font-bold text-slate-800">{{ $matchesOverview['in_progress']['count'] }} ({{ $matchesOverview['in_progress']['percent'] }})</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="text-slate-600 font-medium">Pending Review</span>
                    </div>
                    <span class="font-bold text-slate-800">{{ $matchesOverview['pending']['count'] }} ({{ $matchesOverview['pending']['percent'] }})</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        <span class="text-slate-600 font-medium">Cancelled</span>
                    </div>
                    <span class="font-bold text-slate-800">{{ $matchesOverview['cancelled']['count'] }} ({{ $matchesOverview['cancelled']['percent'] }})</span>
                </div>
            </div>

            <!-- View Full Report link -->
            <div class="mt-3 pt-2 text-center">
                <a href="{{ route('admin.matches') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
                    View Full Report <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Recent Alerts (3 Cols) -->
        <div class="lg:col-span-3 bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Recent Alerts</h3>
                <a href="{{ route('admin.settings') }}#disputes" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">View All</a>
            </div>

            <!-- Alerts List -->
            <div class="space-y-3.5 my-3 flex-1">
                @foreach($recentAlerts as $alert)
                    <div class="flex items-start gap-2.5">
                        <div class="w-7 h-7 rounded-lg border {{ $alert['bg'] }} flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid {{ $alert['icon'] }} text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $alert['title'] }}</p>
                                <span class="text-[9px] text-slate-400 font-medium shrink-0 ml-1">{{ $alert['time'] }}</span>
                            </div>
                            <p class="text-[10px] text-slate-500 leading-tight mt-0.5">{{ $alert['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Row 3: Bottom 4 Columns (Top Categories, Revenue Overview, System Health, Quick Actions) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        
        <!-- Col 1: Top Performing Categories -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Top Performing Categories</h3>
                    <p class="text-[10px] text-slate-400">By successful matches</p>
                </div>
                <a href="{{ route('admin.analytics') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">View All</a>
            </div>

            <div class="space-y-3 my-3">
                @foreach($topCategories as $cat)
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg {{ $cat['bg'] }} flex items-center justify-center">
                                <i class="fa-solid {{ $cat['icon'] }} text-xs"></i>
                            </div>
                            <span class="font-bold text-slate-800 text-[11px]">{{ $cat['name'] }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-slate-600 font-semibold text-[11px]">{{ $cat['matches'] }}</span>
                            <span class="text-emerald-600 font-bold text-[10px]"><i class="fa-solid fa-arrow-up text-[8px]"></i> {{ $cat['growth'] }}</span>
                            <span class="text-amber-500 font-bold text-[10px] flex items-center gap-0.5">
                                <i class="fa-solid fa-star text-[9px]"></i> {{ $cat['rating'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Col 2: Revenue Overview -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Revenue Overview</h3>
                </div>
                <a href="{{ route('admin.analytics') }}#revenue" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">View Full Report</a>
            </div>

            <div class="mt-2">
                <p class="text-[10px] font-semibold text-slate-400">Total Revenue</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-lg font-black text-slate-900">{{ $revenueData['total'] }}</span>
                    <span class="text-[10px] font-bold text-emerald-600"><i class="fa-solid fa-arrow-up"></i> {{ $revenueData['growth'] }}</span>
                </div>
            </div>

            <!-- Purple Vertical Bar Chart -->
            <div class="my-3 pt-2">
                <div class="h-32 flex items-end justify-between gap-2 border-b border-slate-100 pb-1">
                    @foreach($revenueData['months'] as $m)
                        @php
                            $h = round(($m['val'] / 10) * 100);
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-1 group">
                            <div class="w-full bg-purple-600 rounded-t transition-all" style="height: <?php echo $h; ?>%;"></div>
                            <span class="text-[10px] text-slate-400 font-medium">{{ $m['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Col 3: System Health -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">System Health</h3>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                    <i class="fa-solid fa-circle-check"></i> All Systems Operational
                </span>
            </div>

            <div class="space-y-2.5 my-3 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-slate-600 font-medium text-[11px]">Platform Uptime</span>
                    <span class="font-bold text-slate-900 font-mono text-[11px]">99.9%</span>
                </div>

                @foreach($systemHealth['services'] as $service)
                    <div class="flex items-center justify-between text-[11px]">
                        <span class="text-slate-600 font-medium">{{ $service['name'] }}</span>
                        <span class="inline-flex items-center gap-1.5 font-semibold text-emerald-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $service['status'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            <div class="pt-2 border-t border-slate-100 text-center">
                <a href="{{ route('admin.settings') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
                    View System Status <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Col 4: Quick Actions -->
        <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Quick Actions</h3>

            <div class="space-y-1.5 my-2">
                <a href="{{ route('admin.users', ['role' => 'provider']) }}" class="flex items-center justify-between p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors text-xs font-semibold">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-slate-400 w-4"></i>
                        <span>Add New Provider</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                </a>

                <a href="{{ route('admin.users', ['role' => 'institution']) }}" class="flex items-center justify-between p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors text-xs font-semibold">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-building text-slate-400 w-4"></i>
                        <span>Add New Institution</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                </a>

                <a href="{{ route('admin.settings') }}#communications" class="flex items-center justify-between p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors text-xs font-semibold">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-slate-400 w-4"></i>
                        <span>Create Announcement</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                </a>

                <a href="{{ route('admin.settings') }}#disputes" class="flex items-center justify-between p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors text-xs font-semibold">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-slate-400 w-4"></i>
                        <span>View All Disputes</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                </a>

                <a href="{{ route('admin.analytics') }}" class="flex items-center justify-between p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors text-xs font-semibold">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-file-chart-column text-slate-400 w-4"></i>
                        <span>Generate Report</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                </a>

                <a href="{{ route('admin.settings') }}#content" class="flex items-center justify-between p-2 rounded-lg text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors text-xs font-semibold">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-file-pen text-slate-400 w-4"></i>
                        <span>Manage Content</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

