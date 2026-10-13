@extends('development.journey-layout')
@php($activeStage = 1)
@section('title', 'Parent Journey — All Pages')
@section('body-class', 'parent-pages-index')
@section('wide-content')
<section id="journey-form" class="parent-page-index">
    <p class="report-eyebrow">THE COMPLETE PARENT EXPERIENCE</p>
    <h1 id="journey-title">Every step towards a brighter future.</h1>
    <p>Explore the parent journey, from finding support to following your child’s progress. The sample screens use demonstration details. Create an account to save your own child’s assessment.</p>
    <div class="parent-index-actions"><a class="connection-submit" href="{{ route('get-connected') }}">Get Connected <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a><a href="{{ route('dashboard') }}">My Dashboard →</a></div>
    <div class="parent-page-grid">
        <a href="{{ route('solutions') }}"><span>01</span><div><h2>Solutions & Support</h2><p>Open a solution to explore its key areas.</p></div><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        <a href="{{ route('get-connected') }}"><span>02</span><div><h2>Get Connected & Sign Up</h2><p>Create your account and answer quick questions.</p></div><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        @foreach($screens as $key => $title)<a href="{{ route('development.screens.show', $key) }}"><span>{{ str_pad($loop->iteration + 2, 2, '0', STR_PAD_LEFT) }}</span><div><h2>{{ $title }}</h2><p>{{ in_array($key, ['confirmation', 'dashboard', 'tracking']) ? 'Sample data · explore the experience' : 'Interactive sample screen' }}</p></div><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>@endforeach
    </div>
</section>
@endsection
