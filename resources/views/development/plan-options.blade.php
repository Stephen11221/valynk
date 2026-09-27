@php
    $features = ['Individual' => ['1 child profile', 'Full report & provider matches', 'Tips and resources'], 'Family' => ['Up to 4 child profiles', 'Full reports & matches', 'Parent resources', 'Priority support'], 'Provider' => ['List your services', 'Receive qualified referrals', 'Manage your profile', 'Track impact'], 'Institution' => ['Multiple learner profiles', 'Bulk assessments & matches', 'Impact reporting', 'Dedicated support']];
    $planIcons = ['Individual' => 'user', 'Family' => 'user-group', 'Provider' => 'handshake', 'Institution' => 'building'];
@endphp
<div class="plans-layout">
    <section class="plans-preview" aria-labelledby="preview-title">
        <header><i class="fa-regular fa-file-lines" aria-hidden="true"></i><div><h2 id="preview-title">Preview Your Report</h2><p>Here’s an illustrative sample of a report. Explore insights, strengths and recommended support areas.</p></div></header>
        <div class="plans-report-cover">
            <div class="plans-report-banner"><img class="plans-report-brand" src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK"><h3>Child Development Insights</h3><p>Sample Report · Illustrative only</p></div>
            <div class="plans-report-details"><section><p>Child’s Name: <strong>Amina Wanjiku</strong></p><p>Age: <strong>10 years</strong></p><h4>Key Strengths</h4>@foreach(['Curiosity & Learning', 'Creativity', 'Positive Social Skills'] as $strength)<div class="sample-strength"><span aria-hidden="true"></span>{{ $strength }}</div>@endforeach</section><section><h4>Areas for Growth</h4>@foreach(['Focus & Concentration', 'Emotional Regulation', 'Time Management'] as $area)<p class="sample-area"><i class="fa-solid fa-circle-arrow-up" aria-hidden="true"></i>{{ $area }}</p>@endforeach<h4>Recommended Support</h4><p>Mindset &amp; Confidence Coaching</p><p>Study Skills Development</p><p>Social and Emotional Learning</p></section></div>
        </div>
        <a class="plans-sample-link" href="{{ route('development.sample.pdf') }}" target="_blank" rel="noopener"><i class="fa-solid fa-eye" aria-hidden="true"></i> View Full Sample Report (PDF) <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
        @if($assessment)<a class="plans-own-report" href="{{ route('development.report', $assessment) }}">View {{ $child->name }}’s saved support summary →</a>@else<p class="plans-own-report">Sample content does not represent an assessment of your child.</p>@endif
    </section>
    <div class="plans-selection">
        <fieldset class="plans-fieldset"><legend>1. Select a Plan</legend><div class="plans-grid">
            @foreach(config('development.plans') as $plan => $fee)<label class="plans-card"><input type="radio" name="plan" value="{{ $plan }}" required @checked(old('plan', request('plan', 'Individual')) === $plan)><div class="plans-card-heading"><i class="fa-solid fa-{{ $planIcons[$plan] }}" aria-hidden="true"></i><div><h3>{{ $plan }}</h3><p><strong>KES {{ number_format($fee) }}</strong> / month</p></div></div><ul>@foreach($features[$plan] as $feature)<li><i class="fa-solid fa-circle-check" aria-hidden="true"></i>{{ $feature }}</li>@endforeach</ul></label>@endforeach
        </div></fieldset>
        <fieldset class="plans-fieldset plans-methods"><legend>2. Choose Payment Method</legend><div class="plans-method-grid">@foreach(['Card' => ['credit-card', 'Card Payment', '(Visa / Mastercard)'], 'M-PESA' => ['mobile-screen-button', 'M-Pesa', ''], 'Bank transfer' => ['building-columns', 'Bank Transfer', '']] as $value => [$icon, $label, $hint])<label class="plans-card"><input type="radio" name="method" value="{{ $value }}" required @checked(old('method', request('method', 'Card')) === $value)><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><span>{{ $label }}@if($hint)<small>{{ $hint }}</small>@endif</span></label>@endforeach</div></fieldset>
        <aside class="plans-availability"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><div><h3>Payment availability</h3><p>Plans and prices are a preview. Payments are not available yet; no charge will be made and no payment details are collected.</p></div></aside>
    </div>
</div>
