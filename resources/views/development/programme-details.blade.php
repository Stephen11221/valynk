@extends('development.journey-layout')
@section('title', $programme['name'])
@section('body-class', 'parent-programme-page')
@php
    $screenPreview = false;
    $programmeImage = asset($programme['image'] === 'student' ? 'images/solutions/confidence-hero.png' : 'images/about/family.png');
    $benefits = config('development.programme_benefits');
@endphp
@section('wide-content')
<div class="parent-booking-columns" id="journey-form" tabindex="-1">
    <article class="parent-programme-card"><a class="parent-back" href="{{ route('development.matches', $assessment) }}">← Back to Match & Programmes</a>@include('development.partials.parent-programme-header')@include('development.partials.parent-programme-tabs')</article>
    <aside class="parent-booking-panels"><section class="focus-panel"><h2>Next Intake</h2><p>{{ $programme['date'] }}</p><small>Catalogue dates. Confirm availability and location.</small></section><section class="parent-price-panel"><h2>Programme Investment</h2><div class="parent-total"><p>Listed Fee</p><strong>KES {{ number_format($programme['fee']) }}</strong><small>Confirm the final price with the provider.</small></div>@if($programme['online'])<p class="parent-muted">Listed online fee: KES {{ number_format($programme['online']) }}</p>@endif</section><a class="connection-submit" href="{{ route('development.enquiry', [$assessment, 'selection', 'programme' => $programmeKey]) }}">Choose Programme & Continue <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a><section class="focus-panel"><h2>Plan Your Next Step</h2><p>Save a programme enquiry with your preferred intake and payment option. No booking is confirmed and no payment is collected.</p><a class="parent-back" href="{{ route('development.providers') }}">Explore Verified Providers →</a></section></aside>
</div>
@endsection
