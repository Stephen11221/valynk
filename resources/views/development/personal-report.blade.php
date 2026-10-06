@extends('development.journey-layout')
@section('title', 'Your Child’s Report')
@section('body-class', 'personal-report-page')
@section('progress-label', '4 of 5 completed')
@section('progress-value', '4')
@section('progress-max', '5')
@section('progress-note', 'Your report is ready to review')
@section('form')
<article class="personal-report" id="journey-form" tabindex="-1">
    <header class="personal-report-heading">
        <div><p class="report-eyebrow">Your Child’s Report</p><h1 id="journey-title">A quick summary of {{ $child->name }}’s strengths, needs and next steps.</h1><p>This report is based on the information you provided. It summarises your observations and suggests practical areas to explore for support.</p></div>
        <section class="report-child"><i class="fa-solid fa-user" aria-hidden="true"></i><div><h2>{{ $child->name }}</h2><p><strong>Age:</strong> {{ $child->age }} years</p><p><strong>Grade:</strong> {{ $child->grade }}</p><p><strong>School:</strong> {{ $child->school ?: 'Not provided' }}</p><p><strong>PWD Status:</strong> {{ ['yes' => 'Yes', 'no' => 'No', 'prefer_not_to_say' => 'Prefer not to say'][$child->pwd_status ?? ''] ?? 'Not provided' }}</p></div></section>
    </header>
    <section class="report-section" aria-labelledby="report-strengths"><h2 id="report-strengths"><i class="fa-solid fa-chevron-up" aria-hidden="true"></i> Key Strengths</h2><div class="report-card-grid">@forelse($report['strengths'] as $item)<article class="report-insight"><i class="fa-solid fa-{{ $item['icon'] }}" aria-hidden="true"></i><div><h3>{{ $item['title'] }}</h3><p>{{ $item['description'] }}</p></div></article>@empty<p class="report-empty">Your answers highlight areas where additional support may help. Explore your child’s strengths together as part of the next steps.</p>@endforelse</div></section>
    <section class="report-section" aria-labelledby="report-development"><h2 id="report-development"><i class="fa-solid fa-chevron-up" aria-hidden="true"></i> Areas for Development</h2><div class="report-card-grid report-development">@forelse($report['development'] as $item)<article class="report-insight"><i class="fa-solid fa-{{ $item['icon'] }}" aria-hidden="true"></i><div><h3>{{ $item['title'] }}</h3><p>{{ $item['description'] }}</p></div></article>@empty<p class="report-empty">Your responses show positive habits across the areas assessed. Keep building on them with regular practice.</p>@endforelse</div></section>
    <section class="report-section"><h2><i class="fa-solid fa-chevron-up" aria-hidden="true"></i> Recommended Focus Areas</h2><ol class="report-recommendations">@foreach($report['recommendations'] as $recommendation)<li><span>{{ $loop->iteration }}</span><p>{{ $recommendation }}</p></li>@endforeach</ol></section>
    <details class="report-responses"><summary>Review the answers behind this summary</summary><dl>@foreach($report['observations'] as $item)<div><dt>{{ $item['question'] }}</dt><dd>{{ $item['answer'] }}</dd></div>@endforeach</dl></details>
    <p class="report-note">This summary reflects your observations and is not a clinical assessment.</p>
    <div class="focus-actions"><a class="journey-back" href="{{ route('development.assessment.complete', $child) }}"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back</a><a class="connection-submit" href="{{ route('development.providers') }}">Continue to Match & Programmes <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
</article>
@endsection
@section('completion-panels')
<section class="focus-panel focus-help"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i><div><h2>Next Steps</h2><p>Use this summary to compare relevant programmes and verified providers on VALYNK.</p></div></section>
<section class="focus-panel"><h2>What Happens Next?</h2><ol class="report-next-steps"><li><span>1</span> Review your child’s personalised recommendations</li><li><span>2</span> Explore programmes and providers</li><li><span>3</span> Confirm suitability and request a connection</li></ol></section>
<section class="focus-panel report-download"><i class="fa-regular fa-file-lines" aria-hidden="true"></i><div><button type="button" onclick="window.print()">Download Report (PDF)</button><p>Save a copy for your records. Choose “Save as PDF” in the print dialog.</p></div></section>
@endsection
