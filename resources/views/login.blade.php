<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Log in to your VALYNK account.">
    <title>Login | VALYNK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="login-page">
    @include('partials.navbar')

    <main>
        <div class="login-shell">
            <section class="login-card" aria-labelledby="login-title">
                <div class="login-promo">
                    <div class="login-promo-content">
                        <h1>One Ecosystem.<br><span>Limitless Possibilities.</span></h1>
                        <div class="login-rule"></div>
                        <p class="login-promo-copy">Access trusted services, verified Providers and meaningful opportunities - all in one place.</p>

                        <div class="login-orbit" aria-hidden="true">
                            <div class="login-orbit-node learning"><i class="fa-solid fa-graduation-cap"></i><span>Learning &amp;<br>Education</span></div>
                            <div class="login-orbit-node child"><i class="fa-solid fa-brain"></i><span>Child<br>Development</span></div>
                            <div class="login-orbit-node health"><i class="fa-regular fa-heart"></i><span>Health &amp;<br>Wellbeing</span></div>
                            <div class="login-orbit-node care"><i class="fa-solid fa-briefcase"></i><span>Care &amp;<br>Support</span></div>
                            <div class="login-orbit-node enrichment"><i class="fa-regular fa-star"></i><span>Enrichment &amp;<br>Talent</span></div>
                            <div class="login-orbit-node organization"><i class="fa-solid fa-building-columns"></i><span>Organization<br>Solutions</span></div>
                            <div class="login-orbit-center">V<span>A</span><small>THE LINK THAT DELIVERS</small></div>
                        </div>

                        <div class="login-trust">
                            <i class="fa-solid fa-shield-halved"></i>
                            <div><strong>Trusted. Verified. Matched for You.</strong><span>We take the guesswork out of finding the right support.</span></div>
                        </div>
                    </div>
                </div>

                <div class="login-form-panel">
                    <div class="login-form-wrap">
                        <h2 id="login-title">Welcome Back!</h2>
                        <p class="login-form-subtitle">Log in to your VALYNK account</p>

                        <div class="login-tabs" aria-label="Login method">
                            <span class="login-tab active">Email Login</span>
                        </div>

                        @if(session('status')) <p role="status">{{ session('status') }}</p> @endif
                        @if($errors->any()) <p role="alert">{{ $errors->first() }}</p> @endif
                        <form id="email-panel" class="login-form" method="POST" action="{{ route('login.authenticate') }}">
                            @csrf
                            <label for="email">Email Address</label>
                            <div class="login-field"><input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Enter your email address" autocomplete="email" required><i class="fa-regular fa-envelope"></i></div>

                            <label for="password">Password</label>
                            <div class="login-field"><input id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required><button class="login-password-toggle" type="button" aria-label="Show password"><i class="fa-regular fa-eye"></i></button></div>

                            <div class="login-form-options"><label><input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}> Remember me</label><a class="login-forgot" href="{{ route('password.request') }}">Forgot Password?</a></div>
                            <button class="login-submit" type="submit">Log In</button>
                        </form>

                        <p class="login-signup">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
                        <div class="login-security"><i class="fa-solid fa-shield-halved"></i><div><strong>Secure &amp; Protected</strong><span>Your information is safe with us.<br>We use industry-standard security to protect your data.</span></div></div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    @include('partials.footer')

    <script>
        const passwordToggle = document.querySelector('.login-password-toggle');

        passwordToggle?.addEventListener('click', () => {
            const password = document.querySelector('#password');
            const icon = passwordToggle.querySelector('i');
            const isPassword = password.type === 'password';
            password.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
            passwordToggle.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        });
    </script>
</body>
</html>
