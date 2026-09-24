@extends('layouts.account')

@section('title', 'Account Dashboard')
@section('body-class', 'account-reference')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('css/account-dashboard.css') }}">
@endpush

@section('content')
<div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:15px;padding:20px;margin-bottom:24px;border:1px solid #e5dff4;border-radius:12px;background:#f6f0ff;color:#151447"><div><strong style="font-size:20px">Your child’s development journey</strong><p style="margin:5px 0">Assess needs, explore providers and follow your next steps.</p></div><a href="{{ route('development.home') }}" style="background:#5820a3;color:white;padding:12px 20px;border-radius:7px;font-weight:700">Open family journey →</a></div>
@include('account.partials.status')
<div class="account-board">
    <section class="account-welcome" aria-labelledby="welcome-title">
        <p class="account-eyebrow">{{ $user->account_type }} account</p>
        <h1 id="welcome-title">Welcome to VALYNK.<br><span>Your next step starts here.</span></h1>
        <div class="account-rule"></div>
        <p class="account-intro">A world of trusted support and opportunities, connected around you.</p>
        <div class="account-orbit" role="img" aria-label="VALYNK connects learning and education, child development, health and wellbeing, care and support, enrichment and talent, and organisation solutions.">
            <div class="account-orbit-ring"></div>
            <div class="account-orbit-center"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK"></div>
            @foreach ([
                ['learning', 'graduation-cap', 'Learning & Education'],
                ['child', 'brain', 'Child Development'],
                ['health', 'heart', 'Health & Wellbeing'],
                ['care', 'briefcase', 'Care & Support'],
                ['talent', 'star', 'Enrichment & Talent'],
                ['organisation', 'building-columns', 'Organisation Solutions'],
            ] as [$class, $icon, $label])
                <div class="account-orbit-node {{ $class }}" aria-hidden="true"><i class="fa-solid fa-{{ $icon }}"></i><span>{{ $label }}</span></div>
            @endforeach
        </div>
        <div class="account-trust"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><div><strong>Trusted. Verified. Matched for You.</strong><p>We take the guesswork out of finding the right support.</p></div></div>
    </section>
    <section class="account-panel" aria-labelledby="dashboard-title">
        <header class="account-panel-heading">
            <h2 id="dashboard-title">{{ $user->account_type === 'Partner / Other' ? 'Your Partner Dashboard' : 'Your Dashboard' }}</h2>
            <p>Welcome, <strong>{{ $user->name }}</strong>. Make yourself at home.</p>
        </header>
        <div class="account-section-heading"><span>1</span><div><h3>Explore your opportunities</h3><p>Find the right place to take your next step.</p></div></div>
        <div class="account-actions">
            @foreach ([
                ['solutions', 'user-group', 'Find support', 'Explore solutions for yourself and your community.', 'purple'],
                ['providers', 'users', 'Providers', 'Discover services and the people behind them.', 'orange'],
                ['institutions', 'building', 'Institutions', 'Connect your organisation with opportunities.', 'green'],
                ['about', 'handshake', 'Partnerships', 'Learn how we can create greater impact together.', 'blue'],
            ] as [$destination, $icon, $label, $description, $color])
                <a class="account-action {{ $color }}" href="{{ route($destination) }}"><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><strong>{{ $label }}</strong><p>{{ $description }}</p><span aria-hidden="true">→</span></a>
            @endforeach
        </div>
        <div class="account-section-heading"><span>2</span><div><h3>Your account details</h3><p>Keep your information up to date.</p></div></div>
        <dl class="account-info">
            @foreach ([
                'Full name' => $user->name,
                'Email address' => $user->email,
                'Phone number' => $user->phone ?: 'Not added yet',
                'Location' => $user->location ?: 'Not added yet',
                'Account type' => $user->account_type,
                'Member since' => $user->created_at?->format('d M Y') ?: 'Not available',
            ] as $label => $value)
                <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
            @endforeach
        </dl>
        <a class="account-edit" href="{{ route('account.profile.edit') }}">Edit my profile <span aria-hidden="true">→</span></a>
        <p class="account-privacy"><i class="fa-solid fa-lock" aria-hidden="true"></i> Your information is safe with us. We respect your privacy.</p>
    </section>
</div>
@endsection

@section('footer')
@include('account.partials.footer')
@endsection
