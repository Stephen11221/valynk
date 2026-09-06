<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Create your VALYNK account.">
    <title>Get Started | VALYNK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body class="register-page">
    @include('partials.navbar')
    <main>
        <div class="register-shell">
            <section class="register-card" aria-labelledby="register-title">
                <div class="register-promo"><div class="register-promo-content">
                    <h1>Join VALYNK.<br><span>Let's Get You Started.</span></h1><div class="login-rule"></div>
                    <p class="register-promo-copy">Create your account and unlock a world of trusted support and opportunities.</p>
                    <div class="login-orbit register-orbit" aria-hidden="true">
                        <div class="login-orbit-node learning"><i class="fa-solid fa-graduation-cap"></i><span>Learning &amp;<br>Education</span></div><div class="login-orbit-node child"><i class="fa-solid fa-brain"></i><span>Child<br>Development</span></div><div class="login-orbit-node health"><i class="fa-regular fa-heart"></i><span>Health &amp;<br>Wellbeing</span></div><div class="login-orbit-node care"><i class="fa-solid fa-briefcase"></i><span>Care &amp;<br>Support</span></div><div class="login-orbit-node enrichment"><i class="fa-regular fa-star"></i><span>Enrichment &amp;<br>Talent</span></div><div class="login-orbit-node organization"><i class="fa-solid fa-building-columns"></i><span>Organization<br>Solutions</span></div><div class="login-orbit-center"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK - The link that delivers"></div>
                    </div>
                    <div class="login-trust"><i class="fa-solid fa-shield-halved"></i><div><strong>Trusted. Verified. Matched for You.</strong><span>We take the guesswork out of finding the right support.</span></div></div>
                </div></div>
                <div class="register-form-panel"><div class="register-form-wrap">
                    <h2 id="register-title">Create Your VALYNK Account</h2><p class="register-form-subtitle">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                    <div class="register-step"><span class="register-step-number">1</span><div><strong>Choose your account type</strong><span>Select the option that best describes you.</span></div></div>
                    <div class="register-types" role="radiogroup" aria-label="Account type"><button class="register-type selected" type="button" role="radio" aria-checked="true" data-account-type="Individual / Family"><i class="fa-solid fa-user-group"></i><strong>Individual / Family</strong><span>Find support and solutions for yourself or your family.</span><span class="register-type-check">✓</span></button><button class="register-type" type="button" role="radio" aria-checked="false" data-account-type="Provider"><i class="fa-solid fa-users"></i><strong>Provider</strong><span>Offer your services and connect with people who need you.</span></button><button class="register-type" type="button" role="radio" aria-checked="false" data-account-type="Institution"><i class="fa-solid fa-building"></i><strong>Institution</strong><span>Manage your organisation and empower your community.</span></button><button class="register-type" type="button" role="radio" aria-checked="false" data-account-type="Partner / Other"><i class="fa-solid fa-handshake"></i><strong>Partner / Other</strong><span>Collaborate with us to create greater impact together.</span></button></div>
                    <div class="register-step"><span class="register-step-number">2</span><div><strong>Enter your details</strong></div></div>
                    <form class="register-form" method="POST" action="{{ route('register.store') }}">@csrf<input type="hidden" id="account-type" name="account_type" value="Individual / Family"><div class="register-fields"><div class="register-field"><label for="full-name">Full Name*</label><input id="full-name" name="name" type="text" placeholder="Enter your full name" autocomplete="name" value="{{ old('name') }}" required></div><div class="register-field"><label for="register-email">Email Address*</label><input id="register-email" name="email" type="email" placeholder="Enter your email address" autocomplete="email" value="{{ old('email') }}" required></div><div class="register-field"><label for="phone-number">Phone Number*</label><div class="register-phone"><select aria-label="Country code"><option>🇰🇪 +254</option><option>🇦🇺 +61</option><option>🇺🇸 +1</option></select><input id="phone-number" name="phone" type="tel" placeholder="712 345 678" autocomplete="tel" value="{{ old('phone') }}" required></div></div><div class="register-field register-field-icon"><label for="register-password">Password*</label><input id="register-password" name="password" type="password" placeholder="Create a strong password" autocomplete="new-password" required><button class="register-eye" type="button" aria-label="Show password"><i class="fa-regular fa-eye"></i></button></div><div class="register-field register-field-icon"><label for="confirm-password">Confirm Password*</label><input id="confirm-password" name="password_confirmation" type="password" placeholder="Confirm your password" autocomplete="new-password" required><i class="fa-regular fa-eye"></i></div><div class="register-field register-field-icon"><label for="location">Location</label><select id="location" name="location"><option value="">Select your location</option><option>Nairobi</option><option>Mombasa</option><option>Kisumu</option></select><i class="fa-solid fa-location-dot"></i></div></div><label class="register-terms"><input type="checkbox" name="terms" required> I agree to VALYNK's <a href="#terms">Terms of Use</a> and <a href="#privacy">Privacy Policy</a>.</label><button class="register-submit" type="submit">Create Account <i class="fa-solid fa-arrow-right"></i></button><p class="register-note"><i class="fa-solid fa-lock"></i>Your information is safe with us. We respect your privacy.</p></form>
                </div></div>
            </section>
        </div>
    </main>
    @include('partials.footer')
    <script>
        const accountTypeButtons = document.querySelectorAll('.register-type');
        const accountTypeInput = document.querySelector('#account-type');
        const registerPasswordToggle = document.querySelector('.register-eye');
        accountTypeButtons.forEach((button) => button.addEventListener('click', () => { accountTypeButtons.forEach((item) => { const selected = item === button; item.classList.toggle('selected', selected); item.setAttribute('aria-checked', selected ? 'true' : 'false'); item.querySelector('.register-type-check')?.remove(); if (selected) item.insertAdjacentHTML('beforeend', '<span class="register-type-check">✓</span>'); }); accountTypeInput.value = button.dataset.accountType; }));
        registerPasswordToggle?.addEventListener('click', () => { const password = document.querySelector('#register-password'); const icon = registerPasswordToggle.querySelector('i'); const isPassword = password.type === 'password'; password.type = isPassword ? 'text' : 'password'; icon.classList.toggle('fa-eye', !isPassword); icon.classList.toggle('fa-eye-slash', isPassword); });
    </script>
</body>
</html>
