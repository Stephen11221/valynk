@extends('layouts.admin')

@section('title', 'Subscriptions')
@section('header_title', 'Subscriptions Management')
@section('header_subtitle', 'Track, manage and analyse all active and inactive subscriptions across the platform.')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-4">
        @foreach($stats as $stat)
            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-semibold text-slate-500">{{ $stat['title'] }}</span>
                    <div class="w-7 h-7 rounded-lg {{ $stat['color'] }} flex items-center justify-center">
                        <i class="fa-solid {{ $stat['icon'] }} text-xs"></i>
                    </div>
                </div>
                <div class="mt-2 text-xl font-extrabold text-slate-900">{{ $stat['value'] }}</div>
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
                            foreach ($stat['sparkline'] as $i => $v) {
                                $x = ($i / (count($stat['sparkline']) - 1)) * 100;
                                $y = 30 - (($v - $min) / $range) * 24;
                                $points[] = $x . ',' . $y;
                            }
                        @endphp
                        <polyline fill="none" stroke="{{ $stat['positive'] ? '#10B981' : '#EF4444' }}" stroke-width="2" points="{{ implode(' ', $points) }}" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        <div class="xl:col-span-8 bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="text-base font-bold text-slate-900">All Subscriptions</h3>
                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50">
                        <i class="fa-solid fa-download text-slate-400"></i> Export
                    </button>
                    <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        <i class="fa-solid fa-plus"></i> Create Subscription
                    </button>
                </div>
            </div>

            <div class="p-4 bg-slate-50/80 border-b border-slate-100 flex flex-wrap items-center gap-3 text-xs">
                <div class="relative flex-1 min-w-[220px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Search by subscriber, plan or ID..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                    <option>All Statuses</option>
                    <option>Active</option>
                    <option>Expiring Soon</option>
                    <option>Cancelled</option>
                </select>
                <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                    <option>All Types</option>
                    <option>Family</option>
                    <option>Individual</option>
                    <option>Provider</option>
                    <option>Institution</option>
                </select>
                <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                    <option>All Payment Methods</option>
                    <option>M-Pesa</option>
                    <option>Card</option>
                </select>
                <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-semibold hover:bg-slate-50">
                    <i class="fa-solid fa-filter text-slate-400 text-xs"></i> Filters
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Subscription ID</th>
                            <th class="py-3 px-4">Subscriber</th>
                            <th class="py-3 px-4">User Type</th>
                            <th class="py-3 px-4">Plan</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Billing Cycle</th>
                            <th class="py-3 px-4">Start Date</th>
                            <th class="py-3 px-4">Next Billing Date</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($subscriptions as $subscription)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 font-mono font-bold text-sky-700">{{ $subscription['id'] }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $subscription['subscriber'] }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $subscription['email'] }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-[10px] font-bold text-slate-700">{{ $subscription['userType'] }}</span>
                                </td>
                                <td class="py-3 px-4 font-semibold text-slate-900">{{ $subscription['plan'] }}</td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $subscription['amount'] }}</td>
                                <td class="py-3 px-4">{{ $subscription['billing'] }}</td>
                                <td class="py-3 px-4">{{ $subscription['startDate'] }}</td>
                                <td class="py-3 px-4">{{ $subscription['nextBilling'] }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold {{ $subscription['status_class'] }}">{{ $subscription['status'] }}</span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <button class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100"><i class="fa-solid fa-ellipsis-vertical text-sm"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div>Showing <span class="font-bold text-slate-800">1 to 8</span> of <span class="font-bold text-slate-800">8,642</span> subscriptions</div>
                <div class="flex items-center gap-1">
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-400"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                    <button class="w-7 h-7 rounded-md bg-indigo-600 text-white font-bold">1</button>
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-700">2</button>
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-700">3</button>
                    <span class="px-1 text-slate-400">...</span>
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-700">108</button>
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-400"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                </div>
                <select class="px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-slate-700 font-semibold">
                    <option>10 per page</option>
                    <option>25 per page</option>
                </select>
            </div>
        </div>

        <div class="xl:col-span-4 space-y-6">
            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Subscriptions by Status</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View Report</a>
                </div>
                <div class="flex items-center justify-center py-5">
                    <div class="relative h-32 w-32 rounded-full bg-[conic-gradient(#10B981_0_77%,#F59E0B_77%_96%,#EF4444_96%_100%)]">
                        <div class="absolute inset-[22%] rounded-full bg-white"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-center">
                            <div>
                                <div class="text-xl font-black text-slate-900">8,642</div>
                                <div class="text-[10px] text-slate-500">Total</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-[11px]">
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span><span class="text-slate-600">Active</span></div><span class="font-bold text-slate-800">6,725 (77.8%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span><span class="text-slate-600">Expiring Soon</span></div><span class="font-bold text-slate-800">312 (3.6%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span><span class="text-slate-600">Cancelled</span></div><span class="font-bold text-slate-800">351 (4.1%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-slate-300"></span><span class="text-slate-600">Inactive</span></div><span class="font-bold text-slate-800">1,254 (14.5%)</span></div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">MRR Overview (This Month)</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View Report</a>
                </div>
                <div class="flex items-center justify-between pt-4">
                    <div>
                        <div class="text-2xl font-black text-slate-900">KES 4,256,800</div>
                        <div class="text-[10px] text-emerald-600 font-semibold mt-1"><i class="fa-solid fa-arrow-up"></i> +2% from last month</div>
                    </div>
                </div>
                <div class="mt-4">
                    <svg class="w-full h-28" viewBox="0 0 300 110" preserveAspectRatio="none">
                        <path d="M0,85 L20,80 L40,72 L60,68 L80,65 L100,62 L120,60 L140,56 L160,52 L180,48 L200,42 L220,36 L240,30 L260,26 L280,18 L300,10" fill="none" stroke="#4F46E5" stroke-width="2.5" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Recent Subscriptions</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View All</a>
                </div>
                <div class="space-y-3 mt-3">
                    @foreach([
                        ['name' => 'Mary Wanjiku', 'plan' => 'Family Premium', 'date' => '27 May 2025', 'time' => '10:24 AM'],
                        ['name' => 'John Kamau', 'plan' => 'Individual Plus', 'date' => '27 May 2025', 'time' => '09:58 AM'],
                        ['name' => 'MindWell Center', 'plan' => 'Provider Growth', 'date' => '27 May 2025', 'time' => '09:31 AM'],
                        ['name' => 'Bright Future Academy', 'plan' => 'Institution Pro', 'date' => '27 May 2025', 'time' => '09:12 AM'],
                    ] as $recent)
                        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2 last:border-0 last:pb-0">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center"><i class="fa-solid fa-user"></i></div>
                                <div>
                                    <div class="font-bold text-slate-900 text-[11px]">{{ $recent['name'] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $recent['plan'] }}</div>
                                </div>
                            </div>
                            <div class="text-right text-[10px] text-slate-500">
                                <div>{{ $recent['date'] }}</div>
                                <div>{{ $recent['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
