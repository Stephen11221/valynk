@extends('development.journey-layout')
@section('title', 'Full Assessment — Question '.$questionNumber)
@section('progress-label', count(data_get($assessment->answers, 'personal_development', [])).' of 6 answered')
@section('progress-value', (string) count(data_get($assessment->answers, 'personal_development', [])))
@section('progress-max', '6')
@section('form')
<p class="focus-question-count">Question {{ $questionNumber }} of {{ count(config('development.mindset_questions')) }}</p>
<div class="focus-area"><i class="fa-solid fa-{{ $question['icon'] }}" aria-hidden="true"></i><span>{{ $question['area'] }}</span></div>
<form id="journey-form" method="POST" action="{{ route('development.mindset.save', [$child, $questionNumber]) }}">
    @csrf
    <fieldset class="assessment-question focus-question">
        <legend id="journey-title">{{ $question['label'] }}</legend>
        <p class="assessment-hint">Select one option.</p>
        <div class="assessment-options">
            @foreach($question['options'] as $label => $description)<label class="assessment-option"><input type="radio" name="answer" value="{{ $label }}" required @checked(old('answer', data_get($assessment->answers, 'personal_development.'.$question['key'])) === $label)><span>{{ $label }}<small>{{ $description }}</small></span></label>@endforeach
        </div>
    </fieldset>
    <div class="focus-actions"><a class="journey-back" href="{{ $questionNumber === 1 ? route('development.child.details', $child) : route('development.mindset', [$child, $questionNumber - 1]) }}"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back</a><button class="connection-submit" type="submit">{{ $questionNumber === 6 ? 'Review Answers' : 'Next Question' }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></div>
</form>
@endsection
@section('help-panel')
@if($questionNumber > 1)<section class="focus-panel focus-help"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i><div><h2>Helpful to Know</h2><p>{{ $question['help'] }}</p></div></section>@endif
@endsection
