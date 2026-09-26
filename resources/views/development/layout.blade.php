<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>@yield('title','Child Development') | VALYNK</title><link rel="stylesheet" href="{{ asset('css/development.css').'?v='.filemtime(public_path('css/development.css')) }}"><script src="{{ asset('js/development.js').'?v='.filemtime(public_path('js/development.js')) }}" defer></script></head>
<body class="@yield('body-class') {{ isset($wizard) ? 'wizard' : '' }}">
<a class="skip" href="#main">Skip to content</a>
<aside class="sidebar" id="sidebar"><a class="brand" href="{{ route('development.landing') }}"><span class="brand-symbol">∞</span><span>VALYNK<small>CONNECT · EMPOWER · TRANSFORM</small></span></a>
@if(isset($wizard))
 <div class="side-intro"><h2>Welcome,<br>Let’s Find the Right Support for Your Child.</h2><p>The right support, at the right time, for your child.</p></div>
 <ol class="steps-side">@foreach(['Create Account','Take Assessment','View Report & Match','Pay & Connect'] as $label)<li class="{{ ($wizard??1)===$loop->iteration?'active':'' }}"><b>{{ $loop->iteration }}</b><span>{{ $label }}<small>{{ ['Your family details','Help us understand your child','Get personalised insights','Explore your next step'][$loop->index] }}</small></span></li>@endforeach</ol>
@else
 <nav aria-label="Account navigation">
 @foreach([['development.home','◈','Dashboard'],['development.child','♧','My Children'],['development.providers','⌕','Find Providers'],['development.bookings','▣','My Bookings'],['development.preview','▥','Tracking Delivery'],['development.home','☷','Assessments & Reports'],['development.plans','▤','Plans & Payments'],['account.profile.edit','⚙','Settings']] as [$route,$icon,$label])
 <a class="{{ request()->routeIs($route)&&($route!=='development.preview'||request()->route('page')==='tracking')?'active':'' }}" href="{{ $route==='development.preview'?route($route,'tracking'):route($route) }}"><span aria-hidden="true">{{ $icon }}</span>{{ $label }}</a>
 @endforeach
 </nav>
@endif
<div class="side-art"><p>More<br>Possibilities.<br><em>Brighter<br>Futures.</em></p></div><div class="side-help"><strong>Need help?</strong><a href="{{ route('contact') }}">Contact our support team →</a><a href="{{ route('home') }}">Back to website</a></div></aside>
<div class="workspace"><header class="topbar"><button class="menu-toggle" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">☰</button><form action="{{ route('development.providers') }}" method="get" class="search"><label class="sr-only" for="global-search">Search providers</label><span aria-hidden="true">⌕</span><input id="global-search" name="q" value="{{ request('q') }}" placeholder="Search providers or support…"><button aria-label="Search">→</button></form><div class="user"><span class="avatar">{{ mb_substr(auth()->user()?->name??'Guest',0,1) }}</span><span>Welcome<strong>{{ auth()->user()?->name??'to VALYNK' }}</strong></span>@auth<form method="post" action="{{ route('logout') }}">@csrf<button class="text-button">Log out</button></form>@else<a href="{{ route('login') }}">Log in</a>@endauth</div></header>
<main id="main">
@if(isset($wizard))<a class="journey-close" href="{{ route('solutions') }}" aria-label="Close and return to solutions">×</a>@endif
@if(isset($preview))<div class="notice preview-notice"><strong>Sample journey</strong> Illustrative programmes, people, scores and transactions. No payment is taken and no booking is created. <a href="{{ route('development.home') }}">Open my account →</a></div>@endif
@if(session('status'))<div class="notice success" role="status">{{ session('status') }}</div>@endif
@if($errors->any())<div class="notice error" role="alert"><strong>Please check these details:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@yield('content')
</main><footer><span>© {{ date('Y') }} VALYNK. All rights reserved.</span><a href="{{ route('contact') }}">Help & Support</a><span class="tagline">More Possibilities. Brighter Futures.</span></footer></div></body></html>
