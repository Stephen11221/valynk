@extends('development.journey-layout')
@section('title', 'Assessment Complete')
@section('body-class', 'assessment-complete-page')
@section('progress-label', $questionCount.' of '.$questionCount.' completed')
@section('progress-value', (string) $questionCount)
@section('progress-max', (string) $questionCount)
@section('progress-note', 'All your answers have been saved')
@section('form')
<section class="journey-complete" id="journey-form" tabindex="-1">
    <svg class="journey-complete-illustration" viewBox="0 0 220 200" aria-hidden="true" focusable="false">
        <circle cx="108" cy="100" r="92" fill="#e5f4f8"/>
        <g fill="none" stroke-linecap="round"><path d="M24 27l-12-12M191 48h15" stroke="#ff9400" stroke-width="4"/><path d="M180 26l12-12" stroke="#008b9e" stroke-width="4"/>
            <rect x="50" y="29" width="105" height="140" rx="14" fill="#fff" stroke="#09163c" stroke-width="6"/>
            <path d="M75 49h55M75 63h37" stroke="#edf6f9" stroke-width="7"/>
            <path d="M72 125h44M72 142h28" stroke="#09163c" stroke-width="6"/>
        </g>
        <rect x="73" y="83" width="14" height="24" rx="4" fill="#ff9400"/><rect x="96" y="72" width="14" height="35" rx="4" fill="#95a5ab"/><rect x="119" y="57" width="14" height="50" rx="4" fill="#008b9e"/>
        <circle cx="154" cy="140" r="29" fill="#ff9400" stroke="#09163c" stroke-width="3"/><path d="M141 139l9 9 17-18" fill="none" stroke="#fff" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <h1 id="journey-title">Assessment Complete!</h1>
    <p class="journey-complete-intro">Thank you! We’ve captured key insights about {{ $child->name }}’s current situation. Here’s a quick summary before you view the report.</p>
    <dl class="journey-complete-stats">
        <div><i class="fa-regular fa-clock" aria-hidden="true"></i><div><dt>{{ $questionCount }} of {{ $questionCount }}</dt><dd>Questions<br>completed</dd></div></div>
        <div><i class="fa-solid fa-bullseye" aria-hidden="true"></i><div><dt>{{ count($assessedAreas) }}</dt><dd>Focus areas<br>assessed</dd></div></div>
        <div><i class="fa-regular fa-file-lines" aria-hidden="true"></i><div><dt>Personalised</dt><dd>Response summary<br>ready</dd></div></div>
    </dl>
    <div class="journey-complete-actions">
        <a class="connection-submit" href="{{ $assessment->consented_at ? route('development.report', $assessment) : route('development.assessment', [$child, 5]) }}">View My Child’s Report <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        <a class="journey-back" href="{{ route('development.mindset', [$child, $questionCount]) }}"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to Previous Question</a>
    </div>
    @unless($assessment->consented_at)<p class="journey-complete-consent">Review your answers and confirm consent before opening your report.</p>@endunless
</section>
@endsection
@section('completion-panels')
<section class="focus-panel journey-assessed-areas"><h2>Areas Assessed</h2><p>Based on your six assessment responses.</p><ul>@foreach($assessedAreas as $area)<li><i class="fa-solid fa-{{ ['brain', 'bullseye', 'flag'][$loop->index] ?? 'circle-check' }}" aria-hidden="true"></i><span>{{ $area }}</span><i class="fa-solid fa-circle-check journey-area-check" aria-hidden="true"></i></li>@endforeach</ul></section>
<section class="focus-panel focus-help"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i><div><h2>What’s Next?</h2><p>Review your responses and consent to view your personalised summary. Then explore relevant programmes and providers on VALYNK.</p></div></section>
@endsection
