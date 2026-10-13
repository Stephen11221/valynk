@extends('development.journey-layout')
@section('title', 'Your Account is Ready — Sample')
@section('body-class', 'parent-ready-preview')
@section('wide-content')
<section class="parent-ready-background" id="journey-form"><h1 id="journey-title">Get Connected</h1><p>Discover personalised support for your child.</p><button type="button" class="connection-submit" data-open-ready>Preview Account Ready <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></section>
@include('development.account-ready')
@endsection
