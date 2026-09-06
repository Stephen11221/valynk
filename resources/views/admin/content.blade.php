@extends('layouts.admin')

@section('title', 'Content Management')
@section('header_title', 'Content Management')
@section('header_subtitle', 'Plan, publish, and optimize the platform’s content library.')

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

    <div class="bg-white rounded-xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">All Content</h3>
                <p class="text-[11px] text-slate-500">Manage all published, draft, and scheduled content pieces.</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50">
                    <i class="fa-solid fa-download text-slate-400"></i> Export
                </button>
                <button class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    <i class="fa-solid fa-plus"></i> New Page
                </button>
            </div>
        </div>

        <div class="p-4 bg-slate-50/80 border-b border-slate-100 flex flex-wrap items-center gap-3 text-xs">
            <div class="relative flex-1 min-w-[220px]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Search page title, type, or section..." class="w-full pl-8 pr-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                <option>All Statuses</option>
                <option>Published</option>
                <option>Draft</option>
                <option>Scheduled</option>
            </select>
            <select class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-700 font-medium">
                <option>All Content Types</option>
                <option>Page</option>
                <option>Banner</option>
                <option>Blog Post</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Title</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Section</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Language</th>
                        <th class="py-3 px-4">Last Updated</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($content as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4">
                                <div class="font-semibold text-slate-900">{{ $item['title'] }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-[10px] font-bold text-slate-700">{{ $item['type'] }}</span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">{{ $item['section'] }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[10px] font-bold {{ $item['status_class'] }}">{{ $item['status'] }}</span>
                            </td>
                            <td class="py-3 px-4">{{ $item['language'] }}</td>
                            <td class="py-3 px-4">
                                <div class="font-semibold text-slate-900">{{ $item['updated'] }}</div>
                                <div class="text-[10px] text-slate-400">{{ $item['updated_by'] }}</div>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100"><i class="fa-solid fa-ellipsis-vertical text-sm"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
