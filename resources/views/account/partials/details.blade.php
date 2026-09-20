<section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm" aria-labelledby="account-details-title">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h2 id="account-details-title" class="text-3xl font-bold text-slate-900">Your account details</h2>
        <a href="{{ route('account.profile.edit') }}" class="text-base font-semibold text-indigo-700 hover:underline">Update details →</a>
    </div>
    <dl class="mt-5 grid gap-4 sm:grid-cols-2">
        <div><dt class="text-sm font-semibold uppercase tracking-wide text-slate-500">Name</dt><dd class="mt-1 text-base font-medium text-slate-900">{{ $user->name }}</dd></div>
        <div><dt class="text-sm font-semibold uppercase tracking-wide text-slate-500">Email</dt><dd class="mt-1 break-all text-base font-medium text-slate-900">{{ $user->email }}</dd></div>
        <div><dt class="text-sm font-semibold uppercase tracking-wide text-slate-500">Phone</dt><dd class="mt-1 text-base font-medium text-slate-900">{{ $user->phone ?: 'Not added yet' }}</dd></div>
        <div><dt class="text-sm font-semibold uppercase tracking-wide text-slate-500">Location</dt><dd class="mt-1 text-base font-medium text-slate-900">{{ $user->location ?: 'Not added yet' }}</dd></div>
        <div><dt class="text-sm font-semibold uppercase tracking-wide text-slate-500">Account type</dt><dd class="mt-1 text-base font-medium text-slate-900">{{ $user->account_type }}</dd></div>
        <div><dt class="text-sm font-semibold uppercase tracking-wide text-slate-500">Joined</dt><dd class="mt-1 text-base font-medium text-slate-900">{{ $user->created_at?->format('d M Y') }}</dd></div>
    </dl>
</section>
