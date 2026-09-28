@php
    $selection = ['assessment' => $assessment?->id, 'plan' => $plan, 'method' => $method];
    $planIcon = ['Individual' => 'user', 'Family' => 'user-group', 'Provider' => 'handshake', 'Institution' => 'building'][$plan];
    $features = ['Individual' => ['1 child profile', 'Full report & provider matches', 'Tips and resources', 'Access to your dashboard'], 'Family' => ['Up to 4 child profiles', 'Full reports & matches', 'Parent resources', 'Priority support'], 'Provider' => ['List your services', 'Receive qualified referrals', 'Manage your profile', 'Track impact'], 'Institution' => ['Multiple learner profiles', 'Bulk assessments & matches', 'Impact reporting', 'Dedicated support']][$plan];
@endphp
<div class="checkout-layout">
    <section class="checkout-payment" aria-labelledby="payment-title">
        <h2 id="payment-title">1. Payment Details</h2>
        <p class="checkout-intro">Choose your preferred payment method.</p>
        <nav class="plans-method-grid checkout-methods" aria-label="Payment method">
            @foreach(['Card' => ['credit-card', 'Card Payment', '(Visa / Mastercard)'], 'M-PESA' => ['mobile-screen-button', 'M-Pesa', ''], 'Bank transfer' => ['building-columns', 'Bank Transfer', '']] as $value => [$icon, $label, $hint])
                <a class="checkout-method {{ $method === $value ? 'selected' : '' }}" href="{{ route('development.checkout', array_replace($selection, ['method' => $value])) }}" @if($method === $value) aria-current="true" @endif><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><span>{{ $label }}@if($hint)<small>{{ $hint }}</small>@endif</span><i class="fa-{{ $method === $value ? 'solid fa-circle-check' : 'regular fa-circle' }} checkout-method-check" aria-hidden="true"></i></a>
            @endforeach
        </nav>
        <div class="checkout-unavailable" id="payment-unavailable" role="status"><strong>Payments are not available yet</strong><p>No payment provider is connected. No payment details are collected and no charge will be made.</p></div>
        @if($method === 'Card')
            <fieldset class="checkout-card-fields" disabled><legend class="review-sr-only">Card payment preview — unavailable</legend>
                <label>Card Number<div class="checkout-card-number"><input type="text" placeholder="1234 5678 9012 3456" autocomplete="off"><span aria-hidden="true"><i class="fa-brands fa-cc-visa"></i> <i class="fa-brands fa-cc-mastercard"></i></span></div></label>
                <label>Name on Card<input type="text" placeholder="e.g. John Kamau" autocomplete="off"></label>
                <div class="checkout-field-row"><label>Expiry Date<input type="text" placeholder="MM / YY" autocomplete="off"></label><label>CVV<input type="text" placeholder="123" autocomplete="off"></label></div>
            </fieldset>
        @elseif($method === 'M-PESA')
            <div class="checkout-method-message"><i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i><h3>M-Pesa</h3><p>M-Pesa payments are not enabled yet. No payment request will be sent to your phone.</p></div>
        @else
            <div class="checkout-method-message"><i class="fa-solid fa-building-columns" aria-hidden="true"></i><h3>Bank Transfer</h3><p>Bank transfer instructions are not available yet. Contact our team for payment availability.</p></div>
        @endif
        <p class="checkout-security"><i class="fa-solid fa-lock" aria-hidden="true"></i><span>Your selection is a preview. Card and mobile-money details cannot be entered on this page.</span></p>
    </section>
    <div>
        <section class="checkout-order" aria-labelledby="order-title"><h2 id="order-title">2. Order Summary</h2><div class="checkout-order-inner">
            <header><i class="fa-solid fa-{{ $planIcon }}" aria-hidden="true"></i><div><h3>{{ $plan }} Plan</h3><p><strong>KES {{ number_format(config('development.plans.'.$plan)) }}</strong> / month</p></div><a href="{{ route('development.plans', $selection) }}">Change Plan</a></header>
            <ul>@foreach($features as $feature)<li><i class="fa-solid fa-square-check" aria-hidden="true"></i>{{ $feature }}</li>@endforeach</ul>
            <div class="checkout-total"><strong>Total (KES)</strong><p><strong>{{ number_format(config('development.plans.'.$plan)) }}</strong> / month</p></div>
            <a class="checkout-sample" href="{{ route('development.sample.pdf') }}" target="_blank" rel="noopener"><i class="fa-solid fa-eye" aria-hidden="true"></i><span><strong>View What You’ll Get</strong><small>See a sample of the full report.</small></span><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>
        </div></section>
        <aside class="checkout-next"><i class="fa-regular fa-lightbulb" aria-hidden="true"></i><div><h2>Your Next Steps</h2><p>Explore a sample report and review the support available for your child.</p>@if($assessment)<a href="{{ route('development.report', $assessment) }}">View your saved support summary →</a>@endif<a href="{{ route('contact') }}">Contact us about payment availability →</a><a href="{{ route('development.preview', 'success') }}">Preview the payment success page →</a></div></aside>
    </div>
</div>
