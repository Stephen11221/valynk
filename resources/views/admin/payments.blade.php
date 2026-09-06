@extends('layouts.admin')

@section('title', 'Payments')
@section('header_title', 'Payment Management')
@section('header_subtitle', 'Monitor payments, settlements, refunds, and financial performance.')

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
                    <input type="text" placeholder="Search by ID, reference, user, or provider..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                    <option>All Statuses</option>
                    <option>Completed</option>
                    <option>Failed</option>
                    <option>Refunded</option>
                </select>
                <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                    <option>All Payment Methods</option>
                    <option>M-Pesa</option>
                    <option>Card (Visa)</option>
                    <option>Bank Transfer</option>
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
                            <th class="py-3 px-4">Payer / User</th>
                            <th class="py-3 px-4">Provider / Institution</th>
                            <th class="py-3 px-4">Type</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Payment Method</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 font-mono font-bold text-sky-700">{{ $payment['id'] }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $payment['date'] }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $payment['time'] }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $payment['user'] }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $payment['user_role'] }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $payment['provider'] }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $payment['institution'] }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-[10px] font-bold text-slate-700">{{ $payment['type'] }}</span>
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-900">{{ $payment['amount'] }}</td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-[10px] font-bold text-slate-700">{{ $payment['method'] }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold {{ $payment['status_class'] }}">{{ $payment['status'] }}</span>
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
                    <h3 class="text-sm font-bold text-slate-900">Payment Overview</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View Report</a>
                </div>
                <div class="flex items-center justify-center py-5">
                    <div class="relative h-32 w-32 rounded-full bg-[conic-gradient(#10B981_0_80%,#F59E0B_80%_93%,#EF4444_93%_100%)]">
                        <div class="absolute inset-[22%] rounded-full bg-white"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-center">
                            <div>
                                <div class="text-xl font-black text-slate-900">KES 12,845,300</div>
                                <div class="text-[10px] text-slate-500">Total Volume</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-[11px]">
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span><span class="text-slate-600">Successful Payments</span></div><span class="font-bold text-slate-800">KES 11,928,700 (92.9%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span><span class="text-slate-600">Pending Payments</span></div><span class="font-bold text-slate-800">KES 643,200 (5.0%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span><span class="text-slate-600">Refunds Processed</span></div><span class="font-bold text-slate-800">KES 273,400 (2.1%)</span></div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Payment by Method</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View Report</a>
                </div>
                <div class="flex items-center justify-center py-5">
                    <div class="relative h-32 w-32 rounded-full bg-[conic-gradient(#10B981_0_65%,#F59E0B_65%_85%,#8B5CF6_85%_100%)]">
                        <div class="absolute inset-[22%] rounded-full bg-white"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-center">
                            <div>
                                <div class="text-xl font-black text-slate-900">KES 12,845,300</div>
                                <div class="text-[10px] text-slate-500">Total</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-[11px]">
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span><span class="text-slate-600">M-Pesa</span></div><span class="font-bold text-slate-800">KES 7,258,600 (56.5%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span><span class="text-slate-600">Card Payments</span></div><span class="font-bold text-slate-800">KES 4,256,100 (33.1%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-violet-500"></span><span class="text-slate-600">Bank Transfer</span></div><span class="font-bold text-slate-800">KES 1,066,900 (8.3%)</span></div>
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span><span class="text-slate-600">Other Methods</span></div><span class="font-bold text-slate-800">KES 263,700 (2.1%)</span></div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-bold text-slate-900">Recent Refunds</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600">View All</a>
                </div>
                <div class="space-y-3 mt-3">
                    @foreach([
                        ['id' => 'PAY-2025-05264', 'name' => 'Amina Hassan', 'source' => 'HealthRise Services', 'amount' => 'KES 2,200', 'date' => '25 May 2025', 'time' => '02:15 PM'],
                        ['id' => 'PAY-2025-05241', 'name' => 'Mark Opiyo', 'source' => 'LearnTech Solutions', 'amount' => 'KES 1,800', 'date' => '25 May 2025', 'time' => '11:20 AM'],
                        ['id' => 'PAY-2025-05217', 'name' => 'Lucy Wambui', 'source' => 'Career Academy', 'amount' => 'KES 3,500', 'date' => '24 May 2025', 'time' => '09:15 AM'],
                    ] as $refund)
                        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2 last:border-0 last:pb-0">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center"><i class="fa-solid fa-rotate-left"></i></div>
                                <div>
                                    <div class="font-bold text-slate-900 text-[11px]">{{ $refund['id'] }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $refund['name'] }} • {{ $refund['source'] }}</div>
                                </div>
                            </div>
                            <div class="text-right text-[10px] text-slate-500">
                                <div class="font-bold text-slate-900">{{ $refund['amount'] }}</div>
                                <div>{{ $refund['date'] }}</div>
                                <div>{{ $refund['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
