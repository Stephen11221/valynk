@extends('layouts.admin')

@section('title', 'Providers')
@section('header_title', 'Provider Management')
@section('header_subtitle', 'Verify, approve and manage service providers across all categories.')

@section('content')
<div class="space-y-6">

    <!-- Row 1: 6 KPI Cards -->
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
                    <div class="mt-1 flex items-center gap-1 text-[10px] font-semibold {{ !empty($kpi['growth_is_down']) ? 'text-rose-600' : 'text-emerald-600' }}">
                        <i class="fa-solid {{ !empty($kpi['growth_is_down']) ? 'fa-arrow-down' : 'fa-arrow-up' }} text-[9px]"></i>
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

    <!-- Main 12 Columns Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: All Providers Table & Controls (8 Cols) -->
        <div class="lg:col-span-8 bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden flex flex-col justify-between">
            
            <div>
                <!-- Header Actions -->
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h3 class="text-base font-bold text-slate-900">All Providers</h3>
                    <div class="flex items-center gap-2.5">
                        <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors shadow-2xs">
                            <i class="fa-solid fa-download text-slate-400"></i> Export
                        </button>
                        <button class="inline-flex items-center gap-1.5 px-4 py-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors shadow-2xs">
                            <i class="fa-solid fa-plus"></i> Add New Provider
                        </button>
                    </div>
                </div>

                <!-- Filter Controls -->
                <div class="p-4 bg-slate-50/60 border-b border-slate-100 flex flex-wrap items-center gap-3 text-xs">
                    <!-- Search Bar -->
                    <div class="relative flex-1 min-w-50">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Search by name, email or business..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700">
                    </div>

                    <!-- Category Filter -->
                    <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 font-medium">
                        <option>All Categories</option>
                        <option>Wellness & Counseling</option>
                        <option>Career Guidance</option>
                        <option>Academic Support</option>
                        <option>Skills Development</option>
                    </select>

                    <!-- Status Filter -->
                    <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 font-medium">
                        <option>All Statuses</option>
                        <option>Approved</option>
                        <option>Pending</option>
                        <option>Rejected</option>
                    </select>

                    <!-- Verification Filter -->
                    <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700 font-medium">
                        <option>All Verification</option>
                        <option>Verified</option>
                        <option>Under Review</option>
                        <option>Not Verified</option>
                    </select>

                    <!-- Filters Button -->
                    <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-semibold hover:bg-slate-50">
                        <i class="fa-solid fa-filter text-slate-400 text-xs"></i> Filters
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                            <tr>
                                <th class="py-3 px-4">Provider</th>
                                <th class="py-3 px-4">Business / Service</th>
                                <th class="py-3 px-4">Category</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4">Verification</th>
                                <th class="py-3 px-4">Rating</th>
                                <th class="py-3 px-4">Joined On</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach($providersList as $provider)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <!-- Provider Info -->
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full {{ $provider['avatar_bg'] }} font-bold text-xs flex items-center justify-center shrink-0">
                                                {{ $provider['initials'] }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 leading-tight">{{ $provider['name'] }}</div>
                                                <div class="text-[10px] text-slate-400 font-mono">{{ $provider['email'] }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Business / Service -->
                                    <td class="py-3 px-4 font-semibold text-slate-800">
                                        {{ $provider['service'] }}
                                    </td>

                                    <!-- Category Badge -->
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold {{ $provider['category_bg'] }}">
                                            {{ $provider['category'] }}
                                        </span>
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $provider['status_bg'] }}">
                                            {{ $provider['status'] }}
                                        </span>
                                    </td>

                                    <!-- Verification Icon & Label -->
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center gap-1.5 font-bold text-[11px] {{ $provider['verification_color'] }}">
                                            <i class="fa-solid {{ $provider['verification_icon'] }} text-xs"></i>
                                            {{ $provider['verification'] }}
                                        </span>
                                    </td>

                                    <!-- Rating Stars -->
                                    <td class="py-3 px-4">
                                        @if($provider['stars'] > 0)
                                            <div class="flex items-center gap-1">
                                                <span class="font-bold text-slate-900 text-xs">{{ $provider['rating'] }}</span>
                                                <div class="flex items-center text-amber-400 text-[10px]">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $provider['stars'])
                                                            <i class="fa-solid fa-star"></i>
                                                        @else
                                                            <i class="fa-regular fa-star text-slate-300"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-slate-400 font-bold">—</span>
                                        @endif
                                    </td>

                                    <!-- Joined On -->
                                    <td class="py-3 px-4 text-slate-500 font-medium">
                                        {{ $provider['joined'] }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 px-4 text-right">
                                        <button class="p-1 text-slate-400 hover:text-slate-700 rounded transition-colors" title="Options">
                                            <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Pagination Footer -->
            <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div>
                    Showing <span class="font-bold text-slate-800">1 to 8</span> of <span class="font-bold text-slate-800">4,156</span> providers
                </div>

                <div class="flex items-center gap-4">
                    <!-- Page Numbers -->
                    <div class="flex items-center gap-1">
                        <button class="w-7 h-7 rounded-md border border-slate-200 bg-white flex items-center justify-center text-slate-400 hover:bg-slate-50">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </button>
                        <button class="w-7 h-7 rounded-md bg-indigo-600 text-white font-bold flex items-center justify-center text-xs">
                            1
                        </button>
                        <button class="w-7 h-7 rounded-md border border-slate-200 bg-white flex items-center justify-center text-slate-700 hover:bg-slate-50 font-medium">
                            2
                        </button>
                        <button class="w-7 h-7 rounded-md border border-slate-200 bg-white flex items-center justify-center text-slate-700 hover:bg-slate-50 font-medium">
                            3
                        </button>
                        <span class="px-1 text-slate-400">...</span>
                        <button class="w-7 h-7 rounded-md border border-slate-200 bg-white flex items-center justify-center text-slate-700 hover:bg-slate-50 font-medium">
                            520
                        </button>
                        <button class="w-7 h-7 rounded-md border border-slate-200 bg-white flex items-center justify-center text-slate-700 hover:bg-slate-50">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Per Page Select -->
                    <div class="flex items-center gap-2">
                        <select class="px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-slate-700 font-semibold focus:outline-none">
                            <option>10 per page</option>
                            <option>25 per page</option>
                            <option>50 per page</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Status Donut, Verification Donut & Recent Registrations (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Card 1: Providers by Status -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Providers by Status</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">View Report</a>
                </div>

                <div class="flex items-center gap-4 my-4">
                    <div class="relative w-28 h-28 shrink-0 flex items-center justify-center">
                        <svg class="w-28 h-28 transform -rotate-90" viewBox="0 0 36 36">
                            <!-- Approved 68.7% (emerald) -->
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#10B981" stroke-width="4.5" stroke-dasharray="68.7 31.3" stroke-dashoffset="0" />
                            <!-- Pending 20.3% (amber) -->
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#F59E0B" stroke-width="4.5" stroke-dasharray="20.3 79.7" stroke-dashoffset="-68.7" />
                            <!-- Rejected 11.0% (rose) -->
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#EF4444" stroke-width="4.5" stroke-dasharray="11.0 89.0" stroke-dashoffset="-89.0" />
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                            <span class="text-sm font-black text-slate-900 leading-none">{{ $statusDonut['total'] }}</span>
                            <span class="text-[8px] font-semibold text-slate-400 mt-0.5">Total</span>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs flex-1">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                <span class="text-slate-600 font-medium">Approved</span>
                            </div>
                            <span class="font-bold text-slate-800 text-[11px]">{{ $statusDonut['approved']['count'] }} ({{ $statusDonut['approved']['percent'] }})</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                                <span class="text-slate-600 font-medium">Pending Review</span>
                            </div>
                            <span class="font-bold text-slate-800 text-[11px]">{{ $statusDonut['pending']['count'] }} ({{ $statusDonut['pending']['percent'] }})</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                                <span class="text-slate-600 font-medium">Rejected</span>
                            </div>
                            <span class="font-bold text-slate-800 text-[11px]">{{ $statusDonut['rejected']['count'] }} ({{ $statusDonut['rejected']['percent'] }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Verification Overview -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Verification Overview</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">View Report</a>
                </div>

                <div class="flex items-center gap-4 my-4">
                    <div class="relative w-28 h-28 shrink-0 flex items-center justify-center">
                        <svg class="w-28 h-28 transform -rotate-90" viewBox="0 0 36 36">
                            <!-- Verified 51.9% (emerald) -->
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#10B981" stroke-width="4.5" stroke-dasharray="51.9 48.1" stroke-dashoffset="0" />
                            <!-- Under Review 28.5% (amber) -->
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#F59E0B" stroke-width="4.5" stroke-dasharray="28.5 71.5" stroke-dashoffset="-51.9" />
                            <!-- Not Verified 19.6% (rose) -->
                            <circle cx="18" cy="18" r="15.915" fill="none" stroke="#EF4444" stroke-width="4.5" stroke-dasharray="19.6 80.4" stroke-dashoffset="-80.4" />
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-none">
                            <span class="text-sm font-black text-slate-900 leading-none">{{ $verificationDonut['total'] }}</span>
                            <span class="text-[8px] font-semibold text-slate-400 mt-0.5">Total</span>
                        </div>
                    </div>

                    <div class="space-y-2 text-xs flex-1">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                <span class="text-slate-600 font-medium">Verified</span>
                            </div>
                            <span class="font-bold text-slate-800 text-[11px]">{{ $verificationDonut['verified']['count'] }} ({{ $verificationDonut['verified']['percent'] }})</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                                <span class="text-slate-600 font-medium">Under Review</span>
                            </div>
                            <span class="font-bold text-slate-800 text-[11px]">{{ $verificationDonut['under_review']['count'] }} ({{ $verificationDonut['under_review']['percent'] }})</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                                <span class="text-slate-600 font-medium">Not Verified</span>
                            </div>
                            <span class="font-bold text-slate-800 text-[11px]">{{ $verificationDonut['not_verified']['count'] }} ({{ $verificationDonut['not_verified']['percent'] }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Recent Provider Registrations -->
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs flex flex-col justify-between">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Recent Provider Registrations</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">View All</a>
                </div>

                <div class="space-y-4 my-3">
                    @foreach($recentRegistrations as $reg)
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $reg['avatar_bg'] }} font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ $reg['initials'] }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 leading-tight">{{ $reg['name'] }}</div>
                                    <div class="text-[10px] text-slate-500 font-medium">{{ $reg['service'] }}</div>
                                </div>
                            </div>
                            <div class="text-right text-[10px]">
                                <div class="font-semibold text-slate-700">{{ $reg['date'] }}</div>
                                <div class="text-slate-400 font-mono">{{ $reg['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-3 border-t border-slate-100 text-center">
                    <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
                        View All Providers <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
