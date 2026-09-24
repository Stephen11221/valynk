@extends('development.layout')
@section('title','Performance, Confidence & Personal Development')
@section('content')
<section class="hero"><div><p class="eyebrow">OUR SOLUTIONS</p><h1>Performance, Confidence<br>& <em>Personal Development</em></h1><p>Build the mindset, habits and personal capabilities for consistent high performance and a fulfilling life.</p><a class="button" href="{{ auth()->check()?route('development.child'):route('development.register') }}">Find support for my child →</a><a class="button secondary" href="{{ route('development.sample') }}">View sample report</a></div><img src="{{ asset('images/about/family.png') }}" alt="A family spending time together"></section>
<div class="section-heading"><div><p class="eyebrow">CONFIDENT. CAPABLE. PREPARED.</p><h2>Key Areas of Support</h2><p>Four core areas that build a stronger, more resilient future.</p></div><span class="pill">For ages 5–25</span></div>
<div class="grid four">@foreach([
 ['◎','Positive Mindset & Self-Belief',['Growth mindset and resilience','Healthy self-talk and identity','Overcoming limiting beliefs','Confidence in new situations']],
 ['◉','Focus, Discipline & Performance Habits',['Improved concentration','Time management skills','Consistent study and work habits','Reduced distractions']],
 ['↗','Motivation, Purpose & Goal Achievement',['Clarity of purpose and direction','Setting meaningful goals','Persistence and grit','Turning potential into action']],
 ['♧','Relationships & Social Confidence',['Effective communication','Positive peer and family relationships','Leadership and teamwork','Confidence in public settings']]
] as [$icon,$title,$items])<article class="card tint tint-{{ $loop->index }}"><span class="icon">{{ $icon }}</span><h3>{{ $title }}</h3><ul class="checks">@foreach($items as $item)<li>{{ $item }}</li>@endforeach</ul></article>@endforeach</div>
<section class="callout"><div><h2>Your child’s brighter future starts here.</h2><p>Tell us about their needs, explore support and choose your next step.</p></div><a class="button" href="{{ auth()->check()?route('development.child'):route('development.register') }}">Get Connected →</a></section>
<div class="grid four trust">@foreach(['Thoughtful support','Personalised guidance','Relevant at every stage','A brighter future'] as $text)<strong>✓ {{ $text }}</strong>@endforeach</div>
@endsection
