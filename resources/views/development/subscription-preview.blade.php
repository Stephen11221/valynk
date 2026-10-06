@extends('development.journey-layout')
@section('title', 'Preview Your Report & Subscription Options')
@section('body-class', 'subscription-preview-page')
@section('wide-content')
<div class="subscription-columns" id="journey-form" tabindex="-1">
    <section class="subscription-report" aria-labelledby="journey-title">
        <p class="report-eyebrow">Your Child’s Report (Preview)</p><h1 id="journey-title">Here is a glimpse of {{ $child->name }}’s results.</h1><p class="subscription-intro">Explore the report and subscription options below for your child’s next steps.</p>
        <div class="subscription-preview-cover">
            <header class="subscription-child"><i class="fa-solid fa-user" aria-hidden="true"></i><div><h2>{{ $child->name }}</h2><p>Age: {{ $child->age }} years <span>|</span> Grade: {{ $child->grade }}</p></div></header>
            <div class="subscription-blurred" aria-hidden="true">@foreach(['Key Strengths' => 'brain', 'Priority Support Areas' => 'bullseye', 'Recommended Focus Areas' => 'people-group'] as $label => $icon)<section><i class="fa-solid fa-{{ $icon }}"></i><div><h3>{{ $label }}</h3><p>Understand your child’s current situation</p><p>Explore practical next steps together</p><p>Find relevant support and programmes</p></div></section>@endforeach</div>
            <div class="subscription-lock"><span><i class="fa-solid fa-lock" aria-hidden="true"></i></span><h2>Subscription Preview</h2><p>Full subscriptions and payment activation are coming soon.</p><a href="{{ route('development.report', $assessment) }}">View your saved assessment summary →</a></div>
        </div>
        <a class="subscription-back" href="{{ route('development.assessment.complete', $child) }}">← Back to assessment</a>
    </section>
    <section class="subscription-selection" aria-labelledby="subscription-title">
        <h2 id="subscription-title">Explore {{ $child->name }}’s Report and Support Options</h2><p class="subscription-intro">Preview subscription plans for assessment insights, recommendations and provider discovery.</p>
        <section class="subscription-benefits"><h3>What you’ll get:</h3><ul>@foreach(['Full Assessment Report' => ['file-lines', 'A summary of the strengths and needs you described.'], 'Personalised Recommendations' => ['bullseye', 'Practical focus areas and suggested next steps.'], 'Provider Discovery' => ['people-group', 'Explore verified providers and compare their services.'], 'Relevant Programmes' => ['desktop', 'Explore support options for your child’s age and goals.'], 'Informed Next Steps' => ['info', 'Review availability, fees and suitability with a provider.']] as $title => [$icon, $description])<li><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><div><h4>{{ $title }}</h4><p>{{ $description }}</p></div></li>@endforeach</ul></section>
        <form method="GET" action="{{ route('development.checkout') }}">
            <input type="hidden" name="assessment" value="{{ $assessment->id }}"><input type="hidden" name="method" value="{{ request('method', 'Card') }}">
            <fieldset class="subscription-plans"><legend>Select a subscription preview</legend>@foreach(config('development.report_subscriptions') as $key => $plan)<label class="subscription-plan">@if($loop->first)<span class="subscription-popular">Monthly Plan</span>@endif<input type="radio" name="plan" value="{{ $key }}" required @checked(request('plan', 'monthly') === $key)><div><h3>{{ $plan['name'] }}</h3><strong>KES {{ number_format($plan['fee']) }}</strong><small>{{ $plan['period'] }}</small></div><ul>@foreach(['Assessment report preview', 'Provider & programme discovery', 'Access preview for '.$plan['days'].' days', $loop->first ? 'Access from any device' : 'Longer access period'] as $feature)<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i>{{ $feature }}</li>@endforeach</ul></label>@endforeach</fieldset>
            <button class="connection-submit" type="submit"><i class="fa-solid fa-lock" aria-hidden="true"></i> Review Subscription Options <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
        </form>
        <p class="subscription-availability"><i class="fa-solid fa-lock" aria-hidden="true"></i> Payments are not available yet. No charge will be made.</p>
    </section>
</div>
@endsection
