@extends('layouts.admin')

@section('title', 'Audit Logs')
@section('header_title', 'Audit Logs')
@section('header_subtitle', 'Track user activities, system events, and changes across the platform for security and compliance.')

@section('content')
@php
    $stats = [
        ['title' => 'Total Events', 'value' => '25,842', 'change' => '18% from last month', 'icon' => 'fa-file-lines', 'color' => 'bg-purple-50 text-purple-600', 'stroke' => '#8B5CF6', 'points' => '0,24 12,18 24,21 36,12 48,16 60,8 72,14 84,7 100,10'],
        ['title' => 'Successful Events', 'value' => '24,651', 'change' => '20% from last month', 'icon' => 'fa-shield-halved', 'color' => 'bg-emerald-50 text-emerald-600', 'stroke' => '#10B981', 'points' => '0,25 12,20 24,22 36,14 48,18 60,10 72,14 84,7 100,11'],
        ['title' => 'Failed Events', 'value' => '1,191', 'change' => '6% from last month', 'icon' => 'fa-triangle-exclamation', 'color' => 'bg-amber-50 text-amber-600', 'stroke' => '#F59E0B', 'points' => '0,11 12,15 24,9 36,17 48,11 60,21 72,16 84,22 100,18'],
        ['title' => 'Unique Users', 'value' => '1,248', 'change' => '15% from last month', 'icon' => 'fa-user', 'color' => 'bg-sky-50 text-sky-600', 'stroke' => '#3B82F6', 'points' => '0,24 12,20 24,22 36,12 48,4 60,16 72,13 84,17 100,10'],
        ['title' => 'Security Events', 'value' => '286', 'change' => '12% from last month', 'icon' => 'fa-lock', 'color' => 'bg-rose-50 text-rose-600', 'stroke' => '#EF4444', 'points' => '0,12 12,18 24,14 36,8 48,13 60,10 72,18 84,17 100,21'],
        ['title' => 'Avg. Response Time', 'value' => '2.3 sec', 'change' => '8% from last month', 'icon' => 'fa-clock', 'color' => 'bg-emerald-50 text-emerald-600', 'stroke' => '#22C55E', 'points' => '0,23 12,21 24,24 36,16 48,18 60,8 72,11 84,6 100,12'],
    ];

    $severity = [
        ['name' => 'Informational', 'value' => '16,254 (62.9%)', 'color' => 'bg-blue-600'],
        ['name' => 'Success', 'value' => '7,683 (26.2%)', 'color' => 'bg-emerald-600'],
        ['name' => 'Warning', 'value' => '1,932 (7.5%)', 'color' => 'bg-amber-500'],
        ['name' => 'Error', 'value' => '873 (3.4%)', 'color' => 'bg-rose-500'],
    ];

    $categories = [
        ['name' => 'User Management', 'value' => '9,842 (38.1%)', 'width' => '100%'],
        ['name' => 'Content Management', 'value' => '4,521 (17.5%)', 'width' => '46%'],
        ['name' => 'System Events', 'value' => '3,986 (15.4%)', 'width' => '41%'],
        ['name' => 'Security Events', 'value' => '2,872 (11.1%)', 'width' => '29%'],
        ['name' => 'Transactions', 'value' => '2,134 (8.2%)', 'width' => '22%'],
        ['name' => 'Others', 'value' => '487 (1.9%)', 'width' => '7%'],
    ];

    $securityEvents = [
        ['title' => 'Failed login attempt', 'description' => 'IP: 203.0.113.45', 'date' => '27 May 2025', 'time' => '09:42 AM', 'icon' => 'fa-shield-halved', 'color' => 'text-rose-600 bg-rose-50'],
        ['title' => 'Password change', 'description' => 'User: Alice M.', 'date' => '27 May 2025', 'time' => '08:15 AM', 'icon' => 'fa-shield-halved', 'color' => 'text-amber-600 bg-amber-50'],
        ['title' => 'Two-factor authentication enabled', 'description' => 'User: Yusuf A.', 'date' => '26 May 2025', 'time' => '04:32 PM', 'icon' => 'fa-shield-halved', 'color' => 'text-emerald-600 bg-emerald-50'],
        ['title' => 'Permission updated', 'description' => 'User: Beth N.', 'date' => '26 May 2025', 'time' => '02:11 PM', 'icon' => 'fa-shield-halved', 'color' => 'text-violet-600 bg-violet-50'],
    ];
@endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        @foreach($stats as $stat)
            <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
                <div class="flex items-center justify-between gap-2"><span class="text-[10px] font-bold text-slate-500">{{ $stat['title'] }}</span><div class="w-7 h-7 rounded-lg {{ $stat['color'] }} flex items-center justify-center shrink-0"><i class="fa-solid {{ $stat['icon'] }} text-xs"></i></div></div>
                <div class="mt-2 text-xl font-black text-slate-900">{{ $stat['value'] }}</div>
                <div class="mt-1 text-[9px] font-semibold {{ in_array($stat['title'], ['Failed Events', 'Security Events']) ? 'text-rose-600' : 'text-emerald-600' }}"><i class="fa-solid {{ in_array($stat['title'], ['Failed Events', 'Security Events']) ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i> {{ $stat['change'] }}</div>
                <svg class="mt-3 w-full h-8" viewBox="0 0 100 30" preserveAspectRatio="none"><polyline fill="none" stroke="{{ $stat['stroke'] }}" stroke-width="2" points="{{ $stat['points'] }}" stroke-linecap="round" stroke-linejoin="round" /></svg>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        <div class="xl:col-span-8 bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between gap-3"><h3 class="text-sm font-bold text-slate-900">Audit Log Entries</h3><button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg"><i class="fa-solid fa-download text-indigo-500"></i> Export</button></div>
            <div class="p-4 bg-slate-50/80 border-b border-slate-100 flex flex-wrap items-center gap-2 text-[10px]"><div class="relative flex-1 min-w-[180px]"><i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i><input type="text" placeholder="Search by user, action or resource..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-slate-200 rounded-lg"></div><select class="px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg"><option>All Actions</option></select><select class="px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg"><option>All Users</option></select><select class="px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg"><option>All Resources</option></select><select class="px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg"><option>All Statuses</option></select><button class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg font-semibold"><i class="fa-solid fa-filter text-indigo-500"></i> Filters</button></div>
+            <div class="overflow-x-auto"><table class="w-full min-w-[950px] text-left text-[10px]"><thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200"><tr><th class="py-3 px-4">Time</th><th class="py-3 px-4">User</th><th class="py-3 px-4">Action</th><th class="py-3 px-4">Resource</th><th class="py-3 px-4">IP Address</th><th class="py-3 px-4">Status</th><th class="py-3 px-4">Details</th></tr></thead><tbody class="divide-y divide-slate-100 text-slate-700">@foreach($auditLogs as $log)<tr class="hover:bg-slate-50/80"><td class="py-2.5 px-4 whitespace-nowrap"><div class="font-semibold text-slate-700">{{ $log['time'] }}</div></td><td class="py-2.5 px-4"><div class="font-bold text-slate-900">{{ $log['user'] }}</div><div class="text-[9px] text-slate-400">{{ $log['role'] }}</div></td><td class="py-2.5 px-4"><span class="rounded px-2 py-1 text-[9px] font-bold {{ $log['action_class'] }}">{{ $log['action'] }}</span><div class="mt-1 text-[9px] text-slate-500">{{ $log['description'] }}</div></td><td class="py-2.5 px-4"><div class="font-semibold text-slate-800">{{ $log['resource'] }}</div><div class="text-[9px] text-slate-400">{{ $log['resource_type'] }}</div></td><td class="py-2.5 px-4 font-mono text-slate-600">{{ $log['ip'] }}</td><td class="py-2.5 px-4"><span class="font-semibold {{ $log['status_class'] }}"><i class="fa-regular {{ $log['status'] === 'Success' ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>{{ $log['status'] }}</span></td><td class="py-2.5 px-4"><button class="font-bold text-indigo-600 hover:text-indigo-800">View</button><button class="ml-4 text-slate-400"><i class="fa-solid fa-ellipsis-vertical"></i></button></td></tr>@endforeach</tbody></table></div>
+            <div class="p-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-500"><span>Showing <strong class="text-slate-800">1 to 10</strong> of <strong class="text-slate-800">25,842</strong> log entries</span><div class="flex gap-1"><button class="h-6 w-6 rounded border border-slate-200">‹</button><button class="h-6 w-6 rounded bg-indigo-600 text-white">1</button><button class="h-6 w-6 rounded border border-slate-200">2</button><button class="h-6 w-6 rounded border border-slate-200">3</button><span class="px-1">...</span><button class="h-6 w-8 rounded border border-slate-200">2,585</button><button class="h-6 w-6 rounded border border-slate-200">›</button></div></div>
+        </div>
+
+        <div class="xl:col-span-4 space-y-6">
+            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center justify-between border-b border-slate-100 pb-3"><h3 class="text-sm font-bold text-slate-900">Events by Severity</h3><a href="#" class="text-[10px] font-bold text-indigo-600">View Report</a></div><div class="flex items-center gap-5 py-5"><div class="relative h-32 w-32 rounded-full bg-[conic-gradient(#2563EB_0_63%,#10B981_63%_89%,#F59E0B_89%_96%,#EF4444_96%_100%)]"><div class="absolute inset-[23%] rounded-full bg-white"></div><div class="absolute inset-0 flex items-center justify-center text-center"><div class="text-lg font-black text-slate-900">25,842<div class="text-[9px] text-slate-500">Total</div></div></div></div><div class="space-y-2 text-[10px]">@foreach($severity as $item)<div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full {{ $item['color'] }}"></span><span class="text-slate-600">{{ $item['name'] }}</span><strong class="text-slate-800">{{ $item['value'] }}</strong></div>@endforeach</div></div></div>
+            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center justify-between border-b border-slate-100 pb-3"><h3 class="text-sm font-bold text-slate-900">Events by Category</h3><a href="#" class="text-[10px] font-bold text-indigo-600">View Report</a></div><div class="mt-4 space-y-3 text-[10px]">@foreach($categories as $category)<div class="flex items-center gap-2"><span class="w-24 shrink-0 text-slate-600">{{ $category['name'] }}</span><div class="h-2 flex-1 rounded-full bg-slate-100 overflow-hidden"><div class="h-full rounded-full bg-indigo-700" style="width: {{ $category['width'] }}"></div></div><strong class="w-20 text-right text-slate-700">{{ $category['value'] }}</strong></div>@endforeach</div></div>
+            <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center justify-between border-b border-slate-100 pb-3"><h3 class="text-sm font-bold text-slate-900">Recent Security Events</h3><a href="#" class="text-[10px] font-bold text-indigo-600">View All</a></div><div class="mt-3 space-y-4">@foreach($securityEvents as $event)<div class="flex items-start gap-2.5"><span class="w-7 h-7 rounded-lg {{ $event['color'] }} flex items-center justify-center shrink-0"><i class="fa-solid {{ $event['icon'] }} text-[11px]"></i></span><div class="flex-1 min-w-0"><div class="flex justify-between gap-2"><p class="text-[10px] font-bold text-slate-800">{{ $event['title'] }}</p><span class="text-[8px] text-slate-400 whitespace-nowrap">{{ $event['date'] }}</span></div><p class="text-[9px] text-slate-500">{{ $event['description'] }}</p><p class="text-[8px] text-slate-400">{{ $event['time'] }}</p></div></div>@endforeach</div><a href="#" class="mt-4 flex items-center justify-center gap-2 text-[10px] font-bold text-indigo-600">View All Security Events <i class="fa-solid fa-arrow-right"></i></a></div>
+        </div>
+    </div>
+
+    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">@foreach([['title' => 'Oldest Log Entry', 'value' => '01 May 2025', 'detail' => '00:00:15 AM', 'icon' => 'fa-calendar-days'], ['title' => 'Retention Period', 'value' => '365 Days', 'detail' => 'Configurable', 'icon' => 'fa-clock'], ['title' => 'Log Storage Used', 'value' => '12.4 GB', 'detail' => 'of 100 GB', 'icon' => 'fa-database'], ['title' => 'Daily Avg. Events', 'value' => '1,023', 'detail' => 'Per Day', 'icon' => 'fa-chart-column'], ['title' => 'Peak Activity Time', 'value' => '10:00 AM - 12:00 PM', 'detail' => 'EAT Time', 'icon' => 'fa-clock'], ['title' => 'Compliance Status', 'value' => 'Compliant', 'detail' => 'All systems secure', 'icon' => 'fa-shield-halved']] as $metric)<div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center gap-2"><span class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center"><i class="fa-solid {{ $metric['icon'] }} text-xs"></i></span><span class="text-[9px] font-bold text-slate-500">{{ $metric['title'] }}</span></div><div class="mt-3 text-xs font-black text-slate-900">{{ $metric['value'] }}</div><div class="text-[9px] text-slate-400">{{ $metric['detail'] }}</div></div>@endforeach</div>
+    <p class="text-center text-[10px] text-slate-500">Audit logs are immutable and securely stored. Last updated: 27 May 2025, 11:59 PM EAT</p>
+</div>
+@endsection
