@extends('layouts.account')
@php($sectionTitles = ['assessments' => 'Assessments & Reports', 'payments' => 'Payments', 'progress' => 'Progress Tracking', 'settings' => 'Settings', 'help' => 'Help & Support'])
@section('title', $sectionTitles[$page])
@section('content')
<div class="family-workspace">
    <header class="family-section-heading"><h1>{{ $sectionTitles[$page] }}</h1><p>Manage your family’s support journey from your dashboard.</p></header>
    @include('account.partials.status')
    @if($page === 'assessments' || $page === 'progress')
        <section class="family-card"><h2>{{ $page === 'progress' ? 'Your Family’s Progress' : 'Your Children’s Assessments' }}</h2>
        @forelse($children as $child)
            @php($childAssessment = $child->assessments->sortByDesc('id')->first())
            <article class="family-list-item"><div><h3>{{ $child->name }}</h3><p>Age {{ $child->age }} · {{ $child->grade }}</p><p>{{ $childAssessment?->consented_at ? 'Assessment completed — report ready' : ($childAssessment ? 'Assessment in progress — part '.min($childAssessment->step, 4).' of 4' : 'Assessment not started') }}</p></div><a href="{{ $childAssessment?->consented_at ? route('development.report', $childAssessment) : route('development.journey', $child) }}">{{ $childAssessment?->consented_at ? 'View Report' : 'Continue Assessment' }} →</a></article>
            @if($childAssessment?->consented_at && data_get($childAssessment->answers, 'programme_enquiry.programme'))<div class="family-section-links"><a href="{{ route('development.enquiry', [$childAssessment, data_get($childAssessment->answers, 'programme_enquiry.requested_at') ? 'confirmation' : 'selection']) }}">View Saved Programme Enquiry →</a></div>@endif
            @if($childAssessment?->consented_at)<div class="family-section-links"><a href="{{ route('development.matches', $childAssessment) }}">{{ $child->name }}’s Match & Programmes →</a><a href="{{ route('development.plans', ['assessment' => $childAssessment->id]) }}">{{ $child->name }}’s Subscription Preview →</a></div>@endif
        @empty<p class="family-muted">No child profiles yet. Add your child to begin an assessment and track their progress.</p>@endforelse
        <div class="family-section-links"><a href="{{ route('development.child') }}">Add Your Child →</a><a href="{{ route('development.home') }}">Manage Child Profiles →</a></div></section>
    @elseif($page === 'payments')
        <section class="family-card"><h2>Your Payments</h2><p class="family-muted">No payments have been recorded. Online payment processing is not available yet.</p><p>Complete your child’s assessment to review the available plans and payment options.</p><div class="family-section-links"><a href="{{ $latestAssessment?->consented_at ? route('development.plans', ['assessment' => $latestAssessment->id]) : ($selectedChild ? route('development.journey', $selectedChild) : route('development.child')) }}">{{ $latestAssessment?->consented_at ? 'Review Plans & Payment Options' : 'Continue Your Support Journey' }} →</a><a href="{{ route('development.bookings') }}">View Provider Requests →</a></div></section>
    @elseif($page === 'settings')
        <section class="family-card"><h2>Account & Security</h2><p class="family-muted">Keep your contact details current and manage your account password.</p><div class="family-section-links"><a href="{{ route('account.profile.edit') }}">Edit My Profile & Password →</a>@if($user->account_type === 'Family')<a href="{{ route('account.family.documents') }}">Manage Private Documents →</a>@endif<a href="{{ route('development.home') }}">Manage Child Profiles →</a><a href="{{ route('contact') }}">Request Account Help →</a></div><form action="{{ route('logout') }}" method="POST" class="family-list-item">@csrf<button type="submit">Log Out</button></form></section>
    @else
        <section class="family-card"><h2>How can we help?</h2><p class="family-muted">Find guidance for your family’s support journey or get in touch with our team.</p><div class="family-section-links"><a href="{{ route('contact') }}">Contact the Support Team →</a><a href="{{ route('how-it-works') }}">How VALYNK Works →</a><a href="{{ route('families') }}">Family Support →</a><a href="{{ route('development.providers') }}">Find Providers →</a></div></section>
    @endif
</div>
@endsection
