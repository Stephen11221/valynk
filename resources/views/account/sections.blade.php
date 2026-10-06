@extends('layouts.account')
@php($sectionTitles = ['assessments' => 'Assessments & Reports', 'payments' => 'Payments', 'progress' => 'Progress Tracking', 'messages' => 'Messages & Provider Requests', 'programmes' => 'Explore Programmes', 'settings' => 'Settings', 'help' => 'Help & Support'])
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
        @empty<p class="family-muted">No child profiles yet. Add your child to begin an assessment and track their progress.</p>@endforelse
        <div class="family-section-links"><a href="{{ route('development.child') }}">Add Your Child →</a><a href="{{ route('development.home') }}">Manage Child Profiles →</a></div></section>
    @elseif($page === 'payments')
        <section class="family-card"><h2>Your Payments</h2><p class="family-muted">No payments have been recorded. Online payment processing is not available yet.</p><p>Complete your child’s assessment to review the available plans and payment options.</p><div class="family-section-links"><a href="{{ $latestAssessment?->consented_at ? route('development.plans', ['assessment' => $latestAssessment->id]) : ($selectedChild ? route('development.journey', $selectedChild) : route('development.child')) }}">{{ $latestAssessment?->consented_at ? 'Review Plans & Payment Options' : 'Continue Your Support Journey' }} →</a><a href="{{ route('development.bookings') }}">View Provider Requests →</a></div></section>
    @elseif($page === 'messages')
        <section class="family-card"><h2>Your Provider Requests</h2>@forelse($connections as $connection)<article class="family-list-item"><div><h3>{{ $connection->provider->user->name }}</h3><p>{{ $connection->provider->service }} · {{ $connection->child->name }}</p><p>{{ $connection->status }} · {{ $connection->created_at->format('d M Y') }}</p></div><a href="{{ route('development.bookings') }}">View Request →</a></article>@empty<p class="family-muted">No provider requests yet. Explore providers to find support for your child.</p>@endforelse<p class="family-muted">Contact our support team for help with your requests. In-app messaging is not available yet.</p><div class="family-section-links"><a href="{{ route('development.providers') }}">Find a Provider →</a><a href="{{ route('contact') }}">Contact Support →</a></div></section>
    @elseif($page === 'programmes')
        <div class="family-section-links">@forelse($publishedSolutions as $key => $solution)<article class="family-card"><h2>{{ $solution['title'] }}</h2><p class="family-muted">{{ $solution['description'] }}</p><a href="{{ route('get-connected', ['solution' => $key]) }}">Explore This Support Area →</a></article>@empty<section class="family-card"><p>No published solutions are available yet.</p><a href="{{ route('contact') }}">Contact Support →</a></section>@endforelse</div>
    @elseif($page === 'settings')
        <section class="family-card"><h2>Account & Security</h2><p class="family-muted">Keep your contact details current and manage your account password.</p><div class="family-section-links"><a href="{{ route('account.profile.edit') }}">Edit My Profile & Password →</a>@if($user->account_type === 'Family')<a href="{{ route('account.family.documents') }}">Manage Private Documents →</a>@endif<a href="{{ route('development.home') }}">Manage Child Profiles →</a><a href="{{ route('contact') }}">Request Account Help →</a></div><form action="{{ route('logout') }}" method="POST" class="family-list-item">@csrf<button type="submit">Log Out</button></form></section>
    @else
        <section class="family-card"><h2>How can we help?</h2><p class="family-muted">Find guidance for your family’s support journey or get in touch with our team.</p><div class="family-section-links"><a href="{{ route('contact') }}">Contact the Support Team →</a><a href="{{ route('how-it-works') }}">How VALYNK Works →</a><a href="{{ route('families') }}">Family Support →</a><a href="{{ route('development.providers') }}">Find Providers →</a></div></section>
    @endif
</div>
@endsection
