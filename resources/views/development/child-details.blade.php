@extends('development.journey-layout')
@section('title', 'Child’s Details')
@section('progress-label', '1 of 5 completed')
@section('progress-value', '1')
@section('progress-max', '5')
@section('form')
<p class="focus-question-count">Step 2 of 5</p>
<h1 id="journey-title" class="journey-details-title">Child’s Details</h1>
<p class="journey-details-intro">Tell us a bit about your child to help us personalise the assessment.</p>
<form id="journey-form" method="POST" action="{{ route('development.child.details.save', $child) }}">
    @csrf
    <div class="journey-details-fields">
        <label>Child’s Full Name <strong>*</strong><span><i class="fa-solid fa-user" aria-hidden="true"></i><input name="child_name" value="{{ old('child_name', $child->name) }}" placeholder="Enter child’s full name" maxlength="120" required autocomplete="name"></span></label>
        <label>Child’s Age <strong>*</strong><span><i class="fa-solid fa-calendar-days" aria-hidden="true"></i><select name="age" required><option value="">Select age</option>@foreach(range(5, 25) as $age)<option value="{{ $age }}" @selected((string) old('age', $child->age) === (string) $age)>{{ $age }} years</option>@endforeach</select></span></label>
        <label>Grade / Level (CBE) <strong>*</strong><span><i class="fa-solid fa-book-open" aria-hidden="true"></i><select name="grade" required><option value="">Select grade/level</option>@php($grades = array_unique(array_merge(['PP1', 'PP2'], array_map(fn ($grade) => 'Grade '.$grade, range(1, 12)), ['College / University', 'Other'], [$child->grade])))@foreach($grades as $grade)@if($grade)<option value="{{ $grade }}" @selected(old('grade', $child->grade) === $grade)>{{ $grade }}</option>@endif @endforeach</select></span></label>
        <label>School <small>(Optional)</small><span><i class="fa-solid fa-school" aria-hidden="true"></i><input name="school" value="{{ old('school', $child->school) }}" placeholder="Enter school name" maxlength="150"></span></label>
        <label>PWD Status <strong>*</strong><span><i class="fa-solid fa-wheelchair" aria-hidden="true"></i><select name="pwd_status" required><option value="">Select PWD status</option>@foreach(['no' => 'No', 'yes' => 'Yes', 'prefer_not_to_say' => 'Prefer not to say'] as $value => $label)<option value="{{ $value }}" @selected(old('pwd_status', $child->pwd_status) === $value)>{{ $label }}</option>@endforeach</select></span><small>Person with a disability.</small></label>
        <label>If Yes, please specify <small>(Optional)</small><span><input class="journey-no-icon" name="pwd_details" value="{{ old('pwd_details', $child->pwd_details) }}" placeholder="e.g. visual, hearing, physical, learning" maxlength="250"></span></label>
    </div>
    <div class="focus-actions"><a class="journey-back" href="{{ route('dashboard') }}"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back</a><button class="connection-submit" type="submit">Next: Start Assessment <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></div>
</form>
@endsection
@section('help-panel')
<section class="focus-panel focus-help"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i><div><h2>Why we ask this?</h2><p>This information helps us personalise the assessment to your child’s age, school level and specific needs so we can recommend the most relevant support, providers and programmes.</p></div></section>
@endsection
