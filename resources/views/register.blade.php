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
                    @if ($errors->any())
                        <div class="register-error" role="alert">{{ $errors->first() }}</div>
                    @endif
                    <div class="register-step"><span class="register-step-number">1</span><div><strong>Choose your account type</strong><span>Select the option that best describes you.</span></div></div>
                    <div class="register-types" role="radiogroup" aria-label="Account type"><button class="register-type selected" type="button" role="radio" aria-checked="true" data-account-type="Individual"><i class="fa-solid fa-user"></i><strong>Individual</strong><span>Find support and solutions for yourself.</span><span class="register-type-check">✓</span></button><button class="register-type" type="button" role="radio" aria-checked="false" data-account-type="Family"><i class="fa-solid fa-user-group"></i><strong>Family</strong><span>Find support and solutions for your family.</span></button><button class="register-type" type="button" role="radio" aria-checked="false" data-account-type="Provider"><i class="fa-solid fa-users"></i><strong>Provider</strong><span>Offer your services and connect with people who need you.</span></button><button class="register-type" type="button" role="radio" aria-checked="false" data-account-type="Institution"><i class="fa-solid fa-building"></i><strong>Institution</strong><span>Manage your organisation and empower your community.</span></button><button class="register-type" type="button" role="radio" aria-checked="false" data-account-type="Partner / Other"><i class="fa-solid fa-handshake"></i><strong>Partner / Other</strong><span>Collaborate with us to create greater impact together.</span></button><button class="register-type" type="button" role="radio" aria-checked="false" data-account-type="Admin"><i class="fa-solid fa-user-shield"></i><strong>Admin</strong><span>Create an administrator account with an existing admin session.</span></button></div>
                    <p id="register-admin-note" class="register-admin-note" hidden>@if(auth()->user()?->is_admin) This account will have full administrator access. @else Log in as an existing administrator before creating another admin account. <a href="{{ route('login') }}">Log in</a> @endif</p>
                    <div class="register-step"><span class="register-step-number">2</span><div><strong>Enter your details</strong></div></div>
                    <form class="register-form" method="POST" action="{{ route('register.store') }}">@csrf<input type="hidden" id="account-type" name="account_type" value="{{ old('account_type', 'Individual') }}"><div class="register-fields"><div class="register-field"><label for="full-name">Full Name*</label><input id="full-name" name="name" type="text" placeholder="Enter your full name" autocomplete="name" value="{{ old('name') }}" required></div><div class="register-field"><label for="register-email">Email Address*</label><input id="register-email" name="email" type="email" placeholder="Enter your email address" autocomplete="email" value="{{ old('email') }}" required></div><div class="register-field"><label for="phone-number">Phone Number*</label><div class="register-phone"><select aria-label="Country code"><option>🇰🇪 +254</option><option>🇦🇺 +61</option><option>🇺🇸 +1</option></select><input id="phone-number" name="phone" type="tel" placeholder="712 345 678" autocomplete="tel" value="{{ old('phone') }}" required></div></div><div class="register-field register-field-icon"><label for="register-password">Password*</label><input id="register-password" name="password" type="password" placeholder="At least 12 characters" minlength="12" autocomplete="new-password" required><button class="register-eye" type="button" data-password-target="register-password" aria-label="Show password" aria-pressed="false"><i class="fa-regular fa-eye" aria-hidden="true"></i></button></div><div class="register-field register-field-icon"><label for="confirm-password">Confirm Password*</label><input id="confirm-password" name="password_confirmation" type="password" placeholder="Confirm your password" minlength="12" autocomplete="new-password" required><button class="register-eye" type="button" data-password-target="confirm-password" aria-label="Show confirm password" aria-pressed="false"><i class="fa-regular fa-eye" aria-hidden="true"></i></button></div><div class="register-field register-field-icon"><label for="location">Location</label><select id="location" name="location"><option value="">Select your location</option><option>Nairobi</option><option>Mombasa</option><option>Kisumu</option></select><i class="fa-solid fa-location-dot"></i></div></div><label class="register-terms"><input type="checkbox" name="terms" required> I agree to VALYNK's <a href="#terms">Terms of Use</a> and <a href="#privacy">Privacy Policy</a>.</label><button class="register-submit" type="submit">Create Account <i class="fa-solid fa-arrow-right"></i></button><p class="register-note"><i class="fa-solid fa-lock"></i>Your information is safe with us. We respect your privacy.</p></form>
                </div></div>
            </section>
        </div>
    </main>
    @include('partials.footer')
    <script>
        const accountTypeButtons = document.querySelectorAll('.register-type');
        const accountTypeInput = document.querySelector('#account-type');
        const adminNote = document.querySelector('#register-admin-note');
        const passwordToggles = document.querySelectorAll('.register-eye');
        const previousAccountType = accountTypeInput.value;
        const initialButton = [...accountTypeButtons].find((button) => button.dataset.accountType === previousAccountType);
        if (initialButton) {
            accountTypeButtons.forEach((button) => {
                const selected = button === initialButton;
                button.classList.toggle('selected', selected);
                button.setAttribute('aria-checked', selected ? 'true' : 'false');
            });
        }
        accountTypeInput.value = initialButton?.dataset.accountType ?? 'Individual';
        adminNote.hidden = accountTypeInput.value !== 'Admin';
        accountTypeButtons.forEach((button) => button.addEventListener('click', () => { accountTypeButtons.forEach((item) => { const selected = item === button; item.classList.toggle('selected', selected); item.setAttribute('aria-checked', selected ? 'true' : 'false'); item.querySelector('.register-type-check')?.remove(); if (selected) item.insertAdjacentHTML('beforeend', '<span class="register-type-check">✓</span>'); }); accountTypeInput.value = button.dataset.accountType; adminNote.hidden = accountTypeInput.value !== 'Admin'; }));
        passwordToggles.forEach((button) => {
            const input = document.getElementById(button.dataset.passwordTarget);
            button.addEventListener('click', () => {
                const reveal = input.type === 'password';
                input.type = reveal ? 'text' : 'password';
                button.setAttribute('aria-label', `${reveal ? 'Hide' : 'Show'} ${input.id === 'confirm-password' ? 'confirm password' : 'password'}`);
                button.setAttribute('aria-pressed', reveal ? 'true' : 'false');
                const icon = button.querySelector('i');
                icon.classList.toggle('fa-eye', !reveal);
                icon.classList.toggle('fa-eye-slash', reveal);
            });
        });
    </script>
</body>
</html>
