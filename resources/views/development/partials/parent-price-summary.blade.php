<section class="parent-price-panel">
    <h2>{{ $screen === 'confirmation' ? 'Payment Summary' : 'Programme Investment' }}</h2>
    <dl><div><dt>Listed programme price</dt><dd>KES {{ number_format($programme['fee']) }}</dd></div>@if($screenPreview)<div class="parent-price-saving"><dt>Sample match discount (15%)</dt><dd>− KES {{ number_format($discount) }}</dd></div>@endif</dl>
    <div class="parent-total"><p>{{ $screenPreview ? 'Sample VALYNK Price' : 'Listed Price' }}</p><strong>KES {{ number_format($total) }}</strong><small>{{ $screenPreview ? 'Illustrative pricing. No payment is processed.' : 'Confirm the final price and payment terms with the provider.' }}</small></div>
    @if($screen === 'confirmation' && $screenPreview)<dl><div><dt>Sample amount paid</dt><dd>KES {{ number_format($amountDue) }}</dd></div><div><dt>Sample balance to pay</dt><dd>KES {{ number_format($balance) }}</dd></div></dl>@endif
</section>
