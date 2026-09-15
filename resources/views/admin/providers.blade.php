@extends('layouts.admin')

@section('title', 'Providers')
@section('header_title', 'Provider Management')
@section('header_subtitle', 'Verify, approve and manage service providers across all categories.')

@section('content')
<div class="space-y-6">
    @if(session('status')) <p role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</p> @endif

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        @foreach([
            ['label' => 'Total Providers', 'value' => $stats['total'], 'icon' => 'fa-users', 'color' => 'text-purple-600 bg-purple-50'],
            ['label' => 'Approved Providers', 'value' => $stats['approved'], 'icon' => 'fa-circle-check', 'color' => 'text-emerald-600 bg-emerald-50'],
            ['label' => 'Pending Review', 'value' => $stats['pending'], 'icon' => 'fa-clock', 'color' => 'text-amber-600 bg-amber-50'],
            ['label' => 'Rejected Providers', 'value' => $stats['rejected'], 'icon' => 'fa-circle-xmark', 'color' => 'text-rose-600 bg-rose-50'],
            ['label' => 'Verified Providers', 'value' => $stats['verified'], 'icon' => 'fa-shield-halved', 'color' => 'text-sky-600 bg-sky-50'],
        ] as $stat)
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between"><span class="text-xs font-semibold text-slate-500">{{ $stat['label'] }}</span><span class="grid h-8 w-8 place-items-center rounded-lg {{ $stat['color'] }}"><i class="fa-solid {{ $stat['icon'] }}"></i></span></div>
                <p class="mt-3 text-2xl font-extrabold text-slate-900">{{ number_format($stat['value']) }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 xl:grid-cols-12">
        <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm xl:col-span-8" aria-labelledby="all-providers-title">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-5">
                <div><h2 id="all-providers-title" class="text-base font-bold text-slate-900">All Providers</h2><p class="mt-1 text-xs text-slate-500">{{ number_format($providers->total()) }} match the current filters</p></div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.providers.export', $filters) }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50"><i class="fa-solid fa-download mr-1"></i> Export CSV</a>
                    <a href="{{ route('admin.providers.create') }}" class="rounded-lg bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700"><i class="fa-solid fa-plus mr-1"></i> Add New Provider</a>
                </div>
            </div>
            <form method="GET" action="{{ route('admin.providers') }}" class="grid gap-3 border-b border-slate-100 bg-slate-50 p-4 sm:grid-cols-2 lg:grid-cols-5">
                <label class="lg:col-span-2"><span class="sr-only">Search providers</span><input name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search name, email or service" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs"></label>
                <label><span class="sr-only">Category</span><select name="category" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs"><option value="">All Categories</option>@foreach($categories as $category)<option value="{{ $category }}" @selected(($filters['category'] ?? '') === $category)>{{ $category }}</option>@endforeach</select></label>
                <label><span class="sr-only">Status</span><select name="status" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs"><option value="">All Statuses</option>@foreach(['Pending', 'Approved', 'Rejected'] as $status)<option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>@endforeach</select></label>
                <label><span class="sr-only">Verification</span><select name="verification" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs"><option value="">All Verification</option>@foreach(['Not Verified', 'Under Review', 'Verified'] as $verification)<option value="{{ $verification }}" @selected(($filters['verification'] ?? '') === $verification)>{{ $verification }}</option>@endforeach</select></label>
                <div class="flex gap-2 lg:col-span-5"><button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-xs font-semibold text-white">Apply filters</button><a href="{{ route('admin.providers') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-700">Clear</a></div>
            </form>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="border-b border-slate-200 bg-slate-50 text-slate-500"><tr><th class="px-4 py-3">Provider</th><th class="px-4 py-3">Service</th><th class="px-4 py-3">Category</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Verification</th><th class="px-4 py-3">Joined</th><th class="px-4 py-3 text-right">Action</th></tr></thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($providers as $provider)
                            @php $profile = $provider->providerProfile; $status = $profile?->status ?? 'Pending'; $verification = $profile?->verification ?? 'Not Verified'; @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3"><strong class="text-slate-900">{{ $provider->name }}</strong><span class="block text-[11px] text-slate-500">{{ $provider->email }}</span></td>
                                <td class="px-4 py-3 text-slate-700">{{ $profile?->service ?: '—' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $profile?->category ?: 'Uncategorised' }}</td>
                                <td class="px-4 py-3"><span class="rounded-full px-2 py-1 font-semibold {{ $status === 'Approved' ? 'bg-emerald-100 text-emerald-800' : ($status === 'Rejected' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">{{ $status }}</span></td>
                                <td class="px-4 py-3 text-slate-700">{{ $verification }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $provider->created_at?->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-right"><a href="{{ route('admin.providers.edit', $provider) }}" class="font-semibold text-indigo-700 hover:underline">Review / Edit</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-10 text-center text-slate-500">No providers match these filters. <a href="{{ route('admin.providers.create') }}" class="font-semibold text-indigo-700">Add a provider</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 bg-slate-50 px-4 py-3 text-xs text-slate-600">
                <span>Showing {{ $providers->firstItem() ?? 0 }}–{{ $providers->lastItem() ?? 0 }} of {{ number_format($providers->total()) }}</span>
                <form method="GET" action="{{ route('admin.providers') }}" class="flex items-center gap-2">@foreach(collect($filters)->except('per_page') as $key => $value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach<label>Rows <select name="per_page" onchange="this.form.submit()" class="rounded border border-slate-300 bg-white px-2 py-1">@foreach([10, 25, 50] as $size)<option value="{{ $size }}" @selected((int)($filters['per_page'] ?? 10) === $size)>{{ $size }}</option>@endforeach</select></label></form>
                {{ $providers->links() }}
            </div>
        </section>

        <div class="space-y-6 xl:col-span-4">
            @include('admin.partials.provider-breakdown', ['title' => 'Providers by Status', 'items' => $statusBreakdown, 'filterKey' => 'status'])
            @include('admin.partials.provider-breakdown', ['title' => 'Verification Overview', 'items' => $verificationBreakdown, 'filterKey' => 'verification'])
            <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between"><h2 class="text-sm font-bold text-slate-900">Recent Registrations</h2><a href="{{ route('admin.providers') }}" class="text-xs font-semibold text-indigo-700">View All</a></div>
                <div class="mt-4 divide-y divide-slate-100">
                    @forelse($recentProviders as $recent)
                        <div class="flex items-center justify-between gap-2 py-3 text-xs"><div><a href="{{ route('admin.providers.edit', $recent) }}" class="font-semibold text-slate-900 hover:text-indigo-700">{{ $recent->name }}</a><p class="text-slate-500">{{ $recent->providerProfile?->service ?: 'Service not set' }}</p></div><span class="text-slate-500">{{ $recent->created_at?->format('d M Y') }}</span></div>
                    @empty
                        <p class="py-4 text-xs text-slate-500">No provider registrations yet.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
