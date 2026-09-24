<footer class="account-footer">
    <div class="account-footer-grid">
        <div class="account-footer-brand"><a href="{{ route('home') }}"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK home"></a><p>Connecting people and organisations with the right support for better outcomes.</p></div>
        <div><h2>Platform</h2><a href="{{ route('solutions') }}">Explore solutions</a><a href="{{ route('how-it-works') }}">How it works</a><a href="{{ route('pricing') }}">Pricing</a></div>
        <div><h2>Our community</h2><a href="{{ route('families') }}">For families</a><a href="{{ route('providers') }}">For providers</a><a href="{{ route('institutions') }}">For institutions</a></div>
        <div><h2>Company</h2><a href="{{ route('about') }}">About VALYNK</a><a href="{{ route('contact') }}">Contact us</a></div>
        <div><h2>Your account</h2><a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('account.profile.edit') }}">My profile</a></div>
    </div>
    <div class="account-footer-bottom">© {{ date('Y') }} VALYNK. All rights reserved.<span>The link that delivers.</span></div>
</footer>
