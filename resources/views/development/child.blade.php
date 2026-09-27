<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $register ? 'Create Your Account' : 'Add Your Child' }} | VALYNK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('css/get-connected.css') }}?v={{ filemtime(public_path('css/get-connected.css')) }}">
    <script src="{{ asset('js/get-connected.js') }}?v={{ filemtime(public_path('js/get-connected.js')) }}" defer></script>
</head>
<body>
<a class="connection-skip" href="#connection-form">Skip to account form</a>
<main class="connection-shell">
    <a class="connection-close" href="{{ route('solutions') }}" aria-label="Close and return to solutions"><i class="fa-solid fa-xmark" aria-hidden="true"></i></a>
    <aside class="connection-story" aria-label="Your selected solution">
        <a class="connection-brand" href="{{ route('home') }}"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK — Connect, Empower, Transform"></a>
        <div class="connection-story-copy">
            <p class="connection-eyebrow">Our Solutions</p>
            <h2>@if($solutionKey === 'performance-confidence' && $solution['title'] === 'Performance, Confidence & Personal Development')Performance, <br>Confidence &amp; <br><span>Personal Development</span>@else{{ $solution['title'] }}@endif</h2>
            <p class="connection-story-intro">The right support, at the right time,<br>for your child.</p>
            <ul class="connection-highlights">@foreach($solution['highlights'] as $highlight)<li><i class="fa-solid fa-{{ ['brain', 'bullseye', 'person', 'star'][$loop->index] }}" aria-hidden="true"></i><span>{{ $highlight }}</span></li>@endforeach</ul>
            <p class="connection-tagline">{{ $solution['tagline'] ?: 'Confident. Capable. Prepared for what’s next.' }}</p>
        </div>
        <img class="connection-portrait" src="{{ ($solution['display_image_url'] ?? $solution['image_url']) ?: asset('images/solutions/confidence-hero.png') }}" alt="A student looking ahead with confidence" referrerpolicy="no-referrer">
    </aside>

    <section class="connection-content" aria-labelledby="connection-title">
        <header class="connection-heading">
            <div><h1 id="connection-title">{{ $register ? 'Create Your Account' : 'Add Your Child' }}</h1><p>Let’s get to know {{ $register ? 'you and ' : '' }}your child.</p></div>
            <ol class="connection-stepper" aria-label="Your progress">@foreach(['Create Account', 'Take Assessment', 'View Report & Match', 'Connect'] as $step)<li @if($loop->first) aria-current="step" @endif><span>{{ $loop->iteration }}</span><p>{{ $step }}</p></li>@endforeach</ol>
        </header>
        <div class="connection-columns">
            <form id="connection-form" class="connection-form" method="POST" action="{{ route($register ? 'development.register.store' : 'development.child.store') }}">
                @csrf
                <input type="hidden" name="solution" value="{{ $solutionKey }}">
                @if($errors->any())<div class="connection-errors" role="alert" tabindex="-1"><strong>Please check your details.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                @if($register)
                    <fieldset><legend>Parent / Guardian Details</legend><div class="connection-fields">
                        @foreach(['name' => ['Full Name', 'text', 'Your full name', 'user', 'name', 255], 'phone' => ['Phone Number', 'tel', '+254 7XX XXX XXX', 'phone', 'tel', 30], 'email' => ['Email Address', 'email', 'you@example.com', 'envelope', 'email', 255], 'password' => ['Create Password', 'password', 'At least 12 characters', 'lock', 'new-password', null], 'password_confirmation' => ['Confirm Password', 'password', 'Confirm your password', 'lock', 'new-password', null]] as $field => [$label, $type, $placeholder, $icon, $autocomplete, $maximum])
                            <div class="connection-field"><label for="{{ $field }}">{{ $label }} <span aria-hidden="true">*</span></label><div class="connection-input"><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><input id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ $type === 'password' ? '' : old($field) }}" autocomplete="{{ $autocomplete }}" required @if($maximum) maxlength="{{ $maximum }}" @endif @if($type === 'password') minlength="12" @endif aria-invalid="{{ $errors->has($field) ? 'true' : 'false' }}">@if($type === 'password')<button type="button" class="password-toggle" data-password-toggle="{{ $field }}" aria-controls="{{ $field }}" aria-label="Show {{ strtolower($label) }}" aria-pressed="false"><i class="fa-solid fa-eye-slash" aria-hidden="true"></i></button>@endif</div></div>
                        @endforeach
                    </div></fieldset>
                @else
                    <p class="connection-account">Signed in as <strong>{{ auth()->user()->name }}</strong>. This child will be added to your account.</p>
                @endif
                <fieldset class="connection-child"><legend>Child’s Details</legend><div class="connection-fields">
                    <div class="connection-field"><label for="child_name">Child’s Full Name <span aria-hidden="true">*</span></label><div class="connection-input"><i class="fa-solid fa-user" aria-hidden="true"></i><input id="child_name" name="child_name" value="{{ old('child_name') }}" placeholder="Child’s full name" required maxlength="120" autocomplete="off"></div></div>
                    <div class="connection-field"><label for="age">Child’s Age <span aria-hidden="true">*</span></label><div class="connection-input"><i class="fa-regular fa-calendar-days" aria-hidden="true"></i><select id="age" name="age" required><option value="">Select age</option>@foreach(range(5, 25) as $age)<option value="{{ $age }}" @selected((string) old('age') === (string) $age)>{{ $age }} years</option>@endforeach</select></div></div>
                    <div class="connection-field"><label for="grade">Grade / Level (CBE) <span aria-hidden="true">*</span></label><div class="connection-input"><i class="fa-solid fa-book-open" aria-hidden="true"></i><select id="grade" name="grade" required><option value="">Select grade/level</option>@foreach(['PP1', 'PP2', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12', 'College / University', 'Vocational training', 'Beyond school', 'Other'] as $grade)<option @selected(old('grade') === $grade)>{{ $grade }}</option>@endforeach</select></div></div>
                    <div class="connection-field"><label for="school">School <small>(Optional)</small></label><div class="connection-input"><i class="fa-solid fa-school" aria-hidden="true"></i><input id="school" name="school" value="{{ old('school') }}" placeholder="Enter school name" maxlength="150"></div></div>
                    <div class="connection-field"><label for="pwd_status">PWD Status <span aria-hidden="true">*</span></label><div class="connection-input"><i class="fa-solid fa-wheelchair" aria-hidden="true"></i><select id="pwd_status" name="pwd_status" required aria-describedby="pwd-help"><option value="">Select PWD status</option>@foreach(['no' => 'No', 'yes' => 'Yes', 'prefer_not_to_say' => 'Prefer not to say'] as $value => $label)<option value="{{ $value }}" @selected(old('pwd_status') === $value)>{{ $label }}</option>@endforeach</select></div><small id="pwd-help">Person with a disability.</small></div>
                    <div class="connection-field"><label for="pwd_details">If Yes, please specify <small>(Optional)</small></label><div class="connection-input no-icon"><input id="pwd_details" name="pwd_details" value="{{ old('pwd_details') }}" placeholder="e.g. visual, hearing, physical, learning" maxlength="250" @disabled(old('pwd_status') !== 'yes')></div></div>
                    <div class="connection-field full-width"><label for="support_notes">Tell Us More <small>(Optional)</small></label><div class="connection-input connection-textarea"><i class="fa-solid fa-comment-dots" aria-hidden="true"></i><textarea id="support_notes" name="support_notes" maxlength="500" rows="3" aria-describedby="notes-counter" placeholder="Share your child’s interests, current challenges, goals or any other information that will help us find the best support.">{{ old('support_notes') }}</textarea><output id="notes-counter" for="support_notes">{{ mb_strlen(old('support_notes', '')) }}/500</output></div></div>
                </div></fieldset>
                @if($register)<label class="connection-consent"><input type="checkbox" name="terms" value="1" required @checked(old('terms'))><span>I agree to creating a family account and storing these details for support and assessment.</span></label>@endif
                <details class="connection-privacy"><summary>How we use your information</summary><p>Your account stores your child’s profile and assessment answers. Sharing with a provider requires separate confirmation. <a href="{{ route('contact') }}">Contact our team</a> to request changes or deletion.</p></details>
                <button type="submit" class="connection-submit">{{ $register ? 'Create Account & Continue' : 'Save Child & Begin Assessment' }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                @if($register)<p class="connection-login">Already have an account? <a href="{{ route('development.login', ['solution' => $solutionKey]) }}">Login here</a></p>@endif
            </form>
            <aside class="connection-next"><h2>What Happens Next?</h2><ol>
                @foreach([['user-plus', 'Create Your Account', 'Set up your family account to get started.'], ['clipboard-list', 'Take a Brief Assessment', 'Tell us about your child’s needs, interests and goals.'], ['file-circle-check', 'View Your Report & Match', 'Review your child’s summary and explore relevant providers.'], ['people-group', 'Connect with a Provider', 'Choose a provider and confirm what information you want to share.']] as [$icon, $title, $description])
                    <li><div class="connection-step-icon"><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i></div><div><h3>{{ $loop->iteration }}. {{ $title }}</h3><p>{{ $description }}</p></div>@unless($loop->last)<i class="fa-solid fa-arrow-down connection-next-arrow" aria-hidden="true"></i>@endunless</li>
                @endforeach
            </ol><div class="connection-security"><i class="fa-solid fa-lock" aria-hidden="true"></i><p>Your information is protected. You choose when to share your child’s details with a provider.</p></div></aside>
        </div>
    </section>
    <footer class="connection-trust">
        @foreach([['check', 'Verified Providers', 'Only vetted, high-quality professionals.'], ['people-group', 'Personalised Matching', 'Support that fits your child’s needs and goals.'], ['leaf', 'Relevant at Every Stage', 'From early years to young adulthood.'], ['star', 'A Brighter Future', 'Build the capabilities for lifelong success.']] as [$icon, $title, $description])<div><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i><p><strong>{{ $title }}</strong><span>{{ $description }}</span></p></div>@endforeach
    </footer>
</main>
</body>
</html>
