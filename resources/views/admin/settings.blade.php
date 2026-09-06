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

        @section('title', 'System Settings')
        @section('header_title', 'System Settings')
        @section('header_subtitle', 'Configure platform preferences, security, integrations, and system configurations.')
                    <span class="text-sky-600">40%</span>
                </div>
        @php
            $stats = [
                ['title' => 'System Uptime', 'value' => '99.9%', 'change' => '+0.2% from last month', 'icon' => 'fa-server', 'color' => 'bg-purple-50 text-purple-600', 'stroke' => '#8B5CF6', 'points' => '0,25 12,21 24,23 36,15 48,18 60,10 72,16 84,8 100,12'],
                ['title' => 'Active Integrations', 'value' => '18', 'change' => '+2 from last month', 'icon' => 'fa-puzzle-piece', 'color' => 'bg-emerald-50 text-emerald-600', 'stroke' => '#10B981', 'points' => '0,26 12,22 24,24 36,14 48,18 60,9 72,13 84,7 100,10'],
                ['title' => 'System Alerts', 'value' => '3', 'change' => '-2 from last month', 'icon' => 'fa-triangle-exclamation', 'color' => 'bg-amber-50 text-amber-600', 'stroke' => '#F59E0B', 'points' => '0,26 12,22 24,24 36,14 48,18 60,9 72,15 84,10 100,14'],
                ['title' => 'Security Score', 'value' => '92 / 100', 'change' => '+5% from last month', 'icon' => 'fa-shield-halved', 'color' => 'bg-emerald-50 text-emerald-600', 'stroke' => '#22C55E', 'points' => '0,26 12,22 24,19 36,14 48,18 60,11 72,14 84,7 100,10'],
                ['title' => 'Data Backups', 'value' => '100%', 'change' => '100% success rate', 'icon' => 'fa-cloud-arrow-up', 'color' => 'bg-sky-50 text-sky-600', 'stroke' => '#3B82F6', 'points' => '0,25 12,20 24,22 36,13 48,17 60,8 72,13 84,6 100,10'],
                ['title' => 'Storage Usage', 'value' => '42%', 'change' => '+5% from last month', 'icon' => 'fa-database', 'color' => 'bg-violet-50 text-violet-600', 'stroke' => '#7C3AED', 'points' => '0,27 12,23 24,24 36,17 48,20 60,12 72,15 84,9 100,12'],
            ];

            $settings = [
                ['name' => 'Site Name', 'category' => 'General', 'description' => 'The name of the platform', 'value' => 'VALYNK', 'updated' => '27 May 2025', 'time' => '10:15 AM', 'by' => 'Admin User', 'icon' => 'fa-gear', 'color' => 'bg-indigo-50 text-indigo-600'],
                ['name' => 'Site URL', 'category' => 'General', 'description' => 'Primary website URL', 'value' => 'https://valynk.co.ke', 'updated' => '27 May 2025', 'time' => '09:45 AM', 'by' => 'Admin User', 'icon' => 'fa-globe', 'color' => 'bg-sky-50 text-sky-600'],
                ['name' => 'Support Email', 'category' => 'Communication', 'description' => 'Default support email address', 'value' => 'support@valynk.co.ke', 'updated' => '26 May 2025', 'time' => '04:20 PM', 'by' => 'Kevin O.', 'icon' => 'fa-envelope', 'color' => 'bg-emerald-50 text-emerald-600'],
                ['name' => 'Support Phone', 'category' => 'Communication', 'description' => 'Default support phone number', 'value' => '+254 700 123 456', 'updated' => '26 May 2025', 'time' => '04:18 PM', 'by' => 'Kevin O.', 'icon' => 'fa-phone', 'color' => 'bg-sky-50 text-sky-600'],
                ['name' => 'Password Policy', 'category' => 'Security', 'description' => 'Password requirements policy', 'value' => 'Strong (8+ chars)', 'updated' => '25 May 2025', 'time' => '02:30 PM', 'by' => 'Admin User', 'icon' => 'fa-lock', 'color' => 'bg-rose-50 text-rose-600'],
                ['name' => 'Two-Factor Auth', 'category' => 'Security', 'description' => 'Require 2FA for admin users', 'value' => 'Enabled', 'updated' => '25 May 2025', 'time' => '11:05 AM', 'by' => 'Admin User', 'icon' => 'fa-shield-halved', 'color' => 'bg-emerald-50 text-emerald-600', 'toggle' => true],
                ['name' => 'Daily Backups', 'category' => 'System', 'description' => 'Enable automatic daily backups', 'value' => 'Enabled', 'updated' => '24 May 2025', 'time' => '10:00 AM', 'by' => 'System', 'icon' => 'fa-cloud-arrow-up', 'color' => 'bg-sky-50 text-sky-600', 'toggle' => true],
                ['name' => 'Session Timeout', 'category' => 'System', 'description' => 'User session timeout duration', 'value' => '30 minutes', 'updated' => '24 May 2025', 'time' => '09:30 AM', 'by' => 'Admin User', 'icon' => 'fa-clock', 'color' => 'bg-violet-50 text-violet-600'],
            ];

            $services = [
                ['name' => 'Web Server', 'status' => 'Operational', 'color' => 'text-emerald-600'],
                ['name' => 'Database', 'status' => 'Operational', 'color' => 'text-emerald-600'],
                ['name' => 'API Services', 'status' => 'Operational', 'color' => 'text-emerald-600'],
                ['name' => 'Payment Gateway', 'status' => 'Operational', 'color' => 'text-emerald-600'],
                ['name' => 'Email Service', 'status' => 'Operational', 'color' => 'text-emerald-600'],
                ['name' => 'File Storage', 'status' => 'Operational', 'color' => 'text-emerald-600'],
                ['name' => 'CDN', 'status' => 'Degraded', 'color' => 'text-amber-600'],
                ['name' => 'SMS Service', 'status' => 'Outage', 'color' => 'text-rose-600'],
            ];

            $activity = [
                ['title' => 'System backup completed', 'description' => 'Daily backup completed successfully.', 'date' => '27 May 2025', 'time' => '02:15 AM', 'icon' => 'fa-circle-check', 'color' => 'text-emerald-600 bg-emerald-50'],
                ['title' => 'Settings updated', 'description' => 'Password policy was updated.', 'date' => '26 May 2025', 'time' => '04:20 PM', 'icon' => 'fa-gear', 'color' => 'text-sky-600 bg-sky-50'],
                ['title' => 'New integration connected', 'description' => 'M-Pesa API integration added.', 'date' => '26 May 2025', 'time' => '11:30 AM', 'icon' => 'fa-plug', 'color' => 'text-violet-600 bg-violet-50'],
                ['title' => 'High API response time', 'description' => 'Payment gateway responding slowly.', 'date' => '25 May 2025', 'time' => '08:45 AM', 'icon' => 'fa-triangle-exclamation', 'color' => 'text-amber-600 bg-amber-50'],
                ['title' => 'System security scan', 'description' => 'No threats detected.', 'date' => '25 May 2025', 'time' => '05:10 AM', 'icon' => 'fa-circle-check', 'color' => 'text-emerald-600 bg-emerald-50'],
            ];
        @endphp

        <div class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                @foreach($stats as $stat)
                    <div class="bg-white p-4 rounded-xl border border-slate-200/80 shadow-2xs">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[10px] font-bold text-slate-500">{{ $stat['title'] }}</span>
                            <div class="w-7 h-7 rounded-lg {{ $stat['color'] }} flex items-center justify-center shrink-0"><i class="fa-solid {{ $stat['icon'] }} text-xs"></i></div>
                        </div>
                        <div class="mt-2 text-xl font-black text-slate-900">{{ $stat['value'] }}</div>
                        <div class="mt-1 text-[9px] font-semibold {{ $stat['title'] === 'System Alerts' ? 'text-rose-600' : 'text-emerald-600' }}"><i class="fa-solid {{ $stat['title'] === 'System Alerts' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i> {{ $stat['change'] }}</div>
                        <svg class="mt-3 w-full h-8" viewBox="0 0 100 30" preserveAspectRatio="none"><polyline fill="none" stroke="{{ $stat['stroke'] }}" stroke-width="2" points="{{ $stat['points'] }}" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
                <div class="xl:col-span-8 bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <h3 class="text-sm font-bold text-slate-900">General Settings</h3>
                        <div class="flex items-center gap-2">
                            <div class="relative"><input type="text" placeholder="Search settings..." class="w-40 pl-3 pr-7 py-1.5 text-[10px] bg-white border border-slate-200 rounded-lg"><i class="fa-solid fa-magnifying-glass absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"></i></div>
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg"><i class="fa-solid fa-filter text-indigo-500"></i> Filters</button>
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[10px] font-semibold text-white bg-indigo-600 rounded-lg"><i class="fa-solid fa-plus"></i> Add Setting</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[760px] text-left text-[10px]">
                            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200"><tr><th class="py-3 px-4">Setting</th><th class="py-3 px-4">Category</th><th class="py-3 px-4">Description</th><th class="py-3 px-4">Value</th><th class="py-3 px-4">Last Updated</th><th class="py-3 px-4">Updated By</th><th class="py-3 px-4">Actions</th></tr></thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @foreach($settings as $setting)
                                    <tr class="hover:bg-slate-50/80"><td class="py-2.5 px-4"><div class="flex items-center gap-2 font-bold text-slate-900"><span class="w-6 h-6 rounded-md {{ $setting['color'] }} flex items-center justify-center"><i class="fa-solid {{ $setting['icon'] }} text-[10px]"></i></span>{{ $setting['name'] }}</div></td><td class="py-2.5 px-4"><span class="rounded bg-indigo-50 px-2 py-1 text-[9px] font-bold text-indigo-600">{{ $setting['category'] }}</span></td><td class="py-2.5 px-4 text-slate-500">{{ $setting['description'] }}</td><td class="py-2.5 px-4 font-semibold text-slate-800">@if(isset($setting['toggle']))<span class="inline-flex h-4 w-8 items-center rounded-full bg-emerald-500 p-0.5"><span class="h-3 w-3 translate-x-4 rounded-full bg-white"></span></span>@else{{ $setting['value'] }}@endif</td><td class="py-2.5 px-4"><div class="font-semibold text-slate-700">{{ $setting['updated'] }}</div><div class="text-[9px] text-slate-400">{{ $setting['time'] }}</div></td><td class="py-2.5 px-4">{{ $setting['by'] }}</td><td class="py-2.5 px-4"><button class="text-slate-400 hover:text-slate-700"><i class="fa-solid fa-ellipsis-vertical"></i></button></td></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-500"><span>Showing <strong class="text-slate-800">1 to 8</strong> of <strong class="text-slate-800">24</strong> settings</span><div class="flex gap-1"><button class="h-6 w-6 rounded border border-slate-200 text-slate-400">‹</button><button class="h-6 w-6 rounded bg-indigo-600 text-white">1</button><button class="h-6 w-6 rounded border border-slate-200">2</button><button class="h-6 w-6 rounded border border-slate-200">3</button><button class="h-6 w-6 rounded border border-slate-200">›</button></div></div>
                </div>

                <div class="xl:col-span-4 space-y-6">
                    <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center justify-between border-b border-slate-100 pb-3"><h3 class="text-sm font-bold text-slate-900">System Status</h3><a href="#" class="text-[10px] font-bold text-indigo-600">View Report</a></div><div class="mt-3 space-y-2.5">@foreach($services as $service)<div class="flex items-center justify-between text-[10px]"><span class="flex items-center gap-2 text-slate-600"><span class="w-2 h-2 rounded-full {{ $service['status'] === 'Operational' ? 'bg-emerald-600' : ($service['status'] === 'Degraded' ? 'bg-amber-500' : 'bg-rose-600') }}"></span>{{ $service['name'] }}</span><span class="font-semibold {{ $service['color'] }}">{{ $service['status'] }}</span></div>@endforeach</div><div class="mt-4 rounded-lg border border-emerald-100 bg-emerald-50 p-3 text-[10px] text-emerald-700"><i class="fa-solid fa-shield-halved mr-1"></i><strong>All critical systems are operational.</strong><br><span class="ml-5 text-emerald-600">Last checked: 27 May 2025, 11:59 PM EAT</span></div></div>
                    <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center justify-between border-b border-slate-100 pb-3"><h3 class="text-sm font-bold text-slate-900">Recent System Activity</h3><a href="#" class="text-[10px] font-bold text-indigo-600">View All</a></div><div class="mt-3 space-y-4">@foreach($activity as $event)<div class="flex items-start gap-2.5"><span class="w-7 h-7 rounded-lg {{ $event['color'] }} flex items-center justify-center shrink-0"><i class="fa-solid {{ $event['icon'] }} text-[11px]"></i></span><div class="min-w-0 flex-1"><div class="flex justify-between gap-2"><p class="text-[10px] font-bold text-slate-800">{{ $event['title'] }}</p><span class="text-[8px] text-slate-400 whitespace-nowrap">{{ $event['date'] }}</span></div><p class="text-[9px] text-slate-500">{{ $event['description'] }}</p><p class="text-[8px] text-slate-400">{{ $event['time'] }}</p></div></div>@endforeach</div><a href="#" class="mt-4 flex items-center justify-center gap-2 text-[10px] font-bold text-indigo-600">View All Activity <i class="fa-solid fa-arrow-right"></i></a></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center justify-between border-b border-slate-100 pb-3"><h3 class="text-xs font-bold text-slate-900">Integration Management</h3><a href="#" class="text-[9px] font-bold text-indigo-600">View All</a></div><div class="mt-3 space-y-2.5 text-[10px]"><div class="flex justify-between"><span><i class="fa-brands fa-mpesa text-emerald-600 mr-2"></i>M-Pesa API</span><b class="text-emerald-600">Connected</b></div><div class="flex justify-between"><span><i class="fa-brands fa-stripe text-sky-600 mr-2"></i>Stripe</span><b class="text-emerald-600">Connected</b></div><div class="flex justify-between"><span><i class="fa-solid fa-envelope text-sky-600 mr-2"></i>Twilio</span><b class="text-amber-600">Degraded</b></div><div class="flex justify-between"><span><i class="fa-brands fa-google text-amber-600 mr-2"></i>Google Analytics</span><b class="text-emerald-600">Connected</b></div></div><a href="#" class="mt-4 block text-center text-[10px] font-bold text-indigo-600">Manage Integrations <i class="fa-solid fa-arrow-right"></i></a></div>
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><h3 class="text-xs font-bold text-slate-900 border-b border-slate-100 pb-3">Security Overview</h3><div class="flex items-center gap-4 py-4"><div class="relative h-24 w-24 rounded-full bg-[conic-gradient(#10B981_0_92%,#E2E8F0_92%)]"><div class="absolute inset-[18%] rounded-full bg-white"></div><div class="absolute inset-0 flex items-center justify-center text-center"><div class="text-lg font-black text-slate-900">92<span class="text-[10px]">/100</span><div class="text-[8px] text-slate-500">Security Score</div></div></div></div><div class="space-y-2 text-[9px]"><div><i class="fa-solid fa-circle text-emerald-500 mr-1"></i>Access Control <b>95/100</b></div><div><i class="fa-solid fa-circle text-emerald-500 mr-1"></i>Data Protection <b>90/100</b></div><div><i class="fa-solid fa-circle text-amber-500 mr-1"></i>Vulnerability Scan <b>88/100</b></div><div><i class="fa-solid fa-circle text-sky-500 mr-1"></i>Security Updates <b>95/100</b></div></div></div><a href="#" class="block text-center text-[10px] font-bold text-indigo-600">Security Settings <i class="fa-solid fa-arrow-right"></i></a></div>
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center justify-between border-b border-slate-100 pb-3"><h3 class="text-xs font-bold text-slate-900">System Configuration</h3><a href="#" class="text-[9px] font-bold text-indigo-600">View All</a></div><div class="mt-3 space-y-3 text-[10px]">@foreach(['General Settings' => 'fa-gear', 'Appearance Settings' => 'fa-pen', 'Email Templates' => 'fa-envelope', 'Notification Settings' => 'fa-bell', 'Localization Settings' => 'fa-globe'] as $label => $icon)<div class="flex items-center justify-between text-slate-600"><span><i class="fa-solid {{ $icon }} text-indigo-500 w-5"></i>{{ $label }}</span><i class="fa-solid fa-chevron-right text-[8px] text-slate-400"></i></div>@endforeach</div><a href="#" class="mt-4 block text-center text-[10px] font-bold text-indigo-600">Configure System <i class="fa-solid fa-arrow-right"></i></a></div>
                <div class="bg-white p-5 rounded-xl border border-slate-200/80 shadow-2xs"><div class="flex items-center justify-between border-b border-slate-100 pb-3"><h3 class="text-xs font-bold text-slate-900">Developer Tools</h3><a href="#" class="text-[9px] font-bold text-indigo-600">View All</a></div><div class="mt-3 space-y-3 text-[10px]">@foreach(['API Keys' => 'fa-key', 'Webhooks' => 'fa-link', 'System Logs' => 'fa-file-lines', 'Database Tools' => 'fa-database', 'Cache Management' => 'fa-cubes'] as $label => $icon)<div class="flex items-center gap-2 text-slate-600"><i class="fa-solid {{ $icon }} text-indigo-500 w-5"></i><span>{{ $label }}<small class="block text-[8px] text-slate-400">Manage system tools</small></span></div>@endforeach</div><a href="#" class="mt-4 block text-center text-[10px] font-bold text-indigo-600">Developer Tools <i class="fa-solid fa-arrow-right"></i></a></div>
            </div>
        </div>
