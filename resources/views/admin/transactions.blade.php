@extends('layouts.admin')

@section('title', 'Transactions')
@section('header_title', 'Transaction Management')
@section('header_subtitle', 'Track and manage all platform transactions in real time.')

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
                        <polyline fill="none" stroke="{{ $stat['positive'] ? '#6366F1' : '#EF4444' }}" stroke-width="2" points="{{ implode(' ', $points) }}" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        <div class="xl:col-span-8 bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="text-base font-bold text-slate-900">All Transactions</h3>
                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50">
                        <i class="fa-solid fa-download text-slate-400"></i> Export
                    </button>
                    <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        <i class="fa-solid fa-plus"></i> More Actions
                    </button>
                </div>
            </div>

            <div class="p-4 bg-slate-50/80 border-b border-slate-100 flex flex-wrap items-center gap-3 text-xs">
                <div class="relative flex-1 min-w-[220px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" placeholder="Search by ID, user, provider or description..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                    <option>All Statuses</option>
                    <option>Completed</option>
                    <option>Failed</option>
                    <option>Refunded</option>
                </select>
                <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                    <option>All Types</option>
                    <option>Service Payment</option>
                    <option>Subscription</option>
                </select>
                <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                    <option>All Payment Methods</option>
                    <option>M-Pesa</option>
                    <option>Card (Visa)</option>
                    <option>Card (Mastercard)</option>
                </select>
                <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-semibold hover:bg-slate-50">
                    <i class="fa-solid fa-filter text-slate-400 text-xs"></i> Filters
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Transaction ID</th>
                            <th class="py-3 px-4">Date & Time</th>
                            <th class="py-3 px-4">User / Client</th>
                            <th class="py-3 px-4">Provider / Institution</th>
                            <th class="py-3 px-4">Type</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Payment Method</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 font-mono font-bold text-sky-700">{{ $transaction['id'] }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $transaction['date'] }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $transaction['time'] }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $transaction['user'] }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $transaction['user_role'] }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $transaction['provider'] }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $transaction['institution'] }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-[10px] font-bold text-slate-700">{{ $transaction['type'] }}</span>
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $transaction['amount'] }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-[10px] font-bold text-slate-700">{{ $transaction['method'] }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold {{ $transaction['status_class'] }}">{{ $transaction['status'] }}</span>
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
                <div>Showing <span class="font-bold text-slate-800">1 to 8</span> of <span class="font-bold text-slate-800">25,842</span> transactions</div>
                <div class="flex items-center gap-1">
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-400"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                    <button class="w-7 h-7 rounded-md bg-indigo-600 text-white font-bold">1</button>
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-700">2</button>
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-700">3</button>
                    <span class="px-1 text-slate-400">...</span>
                    <button class="w-7 h-7 rounded-md border border-slate-200 bg-white text-slate-700">321</button>
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
                    <h3 class="text-sm font-bold text-slate-900">Transactions Overview</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View Report</a>
                </div>
                <div class="mt-4">
                    <svg class="w-full h-44" viewBox="0 0 300 170" preserveAspectRatio="none">
                        <line x1="0" y1="140" x2="300" y2="140" stroke="#E2E8F0" />
                        <line x1="0" y1="100" x2="300" y2="100" stroke="#E2E8F0" />
                        <line x1="0" y1="60" x2="300" y2="60" stroke="#E2E8F0" />
                        <line x1="0" y1="20" x2="300" y2="20" stroke="#E2E8F0" />
                        <path d="M 0 115 L 30 104 L 60 90 L 90 82 L 120 74 L 150 66 L 180 60 L 210 58 L 240 47 L 270 40 L 300 56" fill="none" stroke="#22C55E" stroke-width="2.5" />
                        <path d="M 0 125 L 30 118 L 60 100 L 90 92 L 120 84 L 150 81 L 180 73 L 210 61 L 240 44 L 270 36 L 300 52" fill="none" stroke="#6366F1" stroke-width="2.5" />
                    </svg>
                </div>
                <div class="mt-3 flex items-center justify-between text-[10px] text-slate-400">
                    <span>21 May</span>
                    <span>22 May</span>
                    <span>23 May</span>
                    <span>24 May</span>
                    <span>25 May</span>
                    <span>26 May</span>
                    <span>27 May</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Transactions by Payment Method</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View Report</a>
                </div>
                <div class="flex items-center justify-center py-5">
                    <div class="relative h-32 w-32 rounded-full bg-[conic-gradient(#8B5CF6_0_49%,#F59E0B_49%_72%,#10B981_72%_100%)]">
                        <div class="absolute inset-[22%] rounded-full bg-white"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-center">
                            <div>
                                <div class="text-xl font-black text-slate-900">25,842</div>
                                <div class="text-[10px] text-slate-500">Total</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-[11px]">
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-violet-500"></span><span class="text-slate-600">M-Pesa</span></div><span class="font-bold text-slate-800">12,842 (49.7%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span><span class="text-slate-600">Card Payments</span></div><span class="font-bold text-slate-800">9,568 (37.1%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span><span class="text-slate-600">Bank Transfer</span></div><span class="font-bold text-slate-800">2,184 (8.5%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span><span class="text-slate-600">Other Methods</span></div><span class="font-bold text-slate-800">1,158 (4.7%)</span></div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Recent Failed Transactions</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View All</a>
                </div>
                <div class="space-y-3 mt-3">
                    @foreach([
                        ['id' => 'TRX-2025-05266', 'name' => 'Esther Njeri', 'source' => 'Kids Code Academy', 'date' => '26 May 2025', 'time' => '04:45 PM'],
                        ['id' => 'TRX-2025-05260', 'name' => 'Mark Opiyo', 'source' => 'LearnTech Solutions', 'date' => '25 May 2025', 'time' => '11:20 AM'],
                        ['id' => 'TRX-2025-05215', 'name' => 'Lucy Wambui', 'source' => 'Career Academy', 'date' => '24 May 2025', 'time' => '09:15 AM'],
                    ] as $failed)
                        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2 last:border-0 last:pb-0">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center"><i class="fa-solid fa-xmark"></i></div>
                                <div>
                                    <div class="font-bold text-slate-900 text-[11px]">{{ $failed['id'] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $failed['name'] }} • {{ $failed['source'] }}</div>
                                </div>
                            </div>
                            <div class="text-right text-[10px] text-slate-500">
                                <div>{{ $failed['date'] }}</div>
                                <div>{{ $failed['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
