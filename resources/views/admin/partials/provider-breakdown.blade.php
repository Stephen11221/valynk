@php
    $total = array_sum(array_column($items, 'count'));
    $offset = 0;
    $segments = [];
    foreach ($items as $item) {
        $end = $offset + ($total ? 100 * $item['count'] / $total : 0);
        $segments[] = $item['color'].' '.$offset.'% '.$end.'%';
        $offset = $end;
    }
    $ring = $total ? 'conic-gradient('.implode(', ', $segments).')' : '#e2e8f0';
@endphp
<section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
    <h2 class="border-b border-slate-100 pb-3 text-sm font-bold text-slate-900">{{ $title }}</h2>
    <div class="mt-4 flex flex-wrap items-center gap-4">
        <div class="grid h-28 w-28 shrink-0 place-items-center rounded-full" style="background: {{ $ring }}">
            <div class="grid h-20 w-20 place-items-center rounded-full bg-white text-center"><span class="text-sm font-extrabold text-slate-900">{{ number_format($total) }}</span></div>
        </div>
        <div class="min-w-0 flex-1 space-y-2 text-xs">
            @foreach($items as $item)
                <a href="{{ route('admin.providers', [$filterKey => $item['label']]) }}" class="flex items-center justify-between gap-2 hover:text-indigo-700"><span class="flex items-center gap-2"><span class="h-2 w-2 rounded-full" style="background: {{ $item['color'] }}"></span>{{ $item['label'] }}</span><strong>{{ number_format($item['count']) }} ({{ $total ? number_format(100 * $item['count'] / $total, 1) : '0.0' }}%)</strong></a>
            @endforeach
        </div>
    </div>
</section>
