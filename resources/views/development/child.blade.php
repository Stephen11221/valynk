@php($usesFamilyDashboard = in_array(auth()->user()?->account_type, ['Family', 'Partner / Other'], true))
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
@if($usesFamilyDashboard)
<link rel="stylesheet" href="{{ asset('css/family-dashboard.css') }}?v={{ filemtime(public_path('css/family-dashboard.css')) }}">
<script src="{{ asset('js/family-dashboard.js') }}?v={{ filemtime(public_path('js/family-dashboard.js')) }}" defer></script>
@endif
</head>
<body class="connection-onboarding {{ $usesFamilyDashboard ? 'family-dashboard family-child-page' : '' }}">
@if($usesFamilyDashboard)
@include('account.partials.dashboard-header')
@include('account.partials.dashboard-sidebar')
@endif
<a class="connection-skip" href="#connection-form">Skip to account form</a>
<main class="connection-shell">
    <a class="connection-close" href="{{ route('solutions') }}" aria-label="Close and return to solutions"><i class="fa-solid fa-xmark" aria-hidden="true"></i></a>
    <aside class="connection-story" aria-label="Your selected solution">
        <a class="connection-brand" href="{{ route('home') }}"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK — Connect, Empower, Transform"></a>
        <div class="connection-story-copy">
            <div class="connection-solution-label"><span>01</span><p>{{ $solution['title'] }}</p></div>
            <h2>{{ $solutionKey === 'performance-confidence' && $solution['title'] === config('solutions.performance-confidence.title') ? 'Build Confidence, Resilience and a Positive Self-Image' : $solution['title'] }}</h2>
            <p class="connection-story-intro">{{ $solution['description'] }}</p>
            <ul class="connection-focus-areas">
                @foreach($solution['areas'] as $area)
                    <li><h3>{{ $area['title'] }}</h3><p>{{ implode(', ', array_slice($area['points'], 0, 2)) }}.</p></li>
                @endforeach
            </ul>
        </div>
        <div class="connection-safe"><h3>Safe, Trusted and Personalised</h3><p>Your information is secure and only used to help us connect you to the right support.</p></div>
        <img class="connection-portrait" src="{{ ($solution['display_image_url'] ?? $solution['image_url']) ?: asset('images/solutions/confidence-hero.png') }}" alt="A student looking ahead with confidence" referrerpolicy="no-referrer">
    </aside>

    <section class="connection-content" aria-labelledby="connection-title">
        <header class="connection-heading">
            <ol class="connection-stepper" aria-label="Your progress">@foreach(['Sign Up & Quick Questions', 'Full Assessment', 'Preview Report', 'Match & Programmes'] as $step)<li @if($loop->first) aria-current="step" @endif><span>{{ $loop->iteration }}</span><p>{{ $step }}</p></li>@endforeach</ol>
            <div><h1 id="connection-title">{{ $register ? 'Get Connected' : 'Add Your Child' }}</h1><p>{{ $register ? 'Create your account and answer a few quick questions so we can understand your needs better. This will only take a few minutes.' : 'Answer a few quick questions so we can understand your child’s needs better.' }}</p></div>
        </header>
        <div class="connection-selected"><span><i class="fa-solid fa-people-group" aria-hidden="true"></i></span><div><p>Selected Solution</p><h2>{{ $solution['title'] }}</h2></div><a href="{{ route('solutions') }}#solutions">Change</a></div>
        <div class="connection-columns">
            <form id="connection-form" class="connection-form" method="POST" action="{{ route($register ? 'development.register.store' : 'development.child.store') }}">
                @csrf
                <input type="hidden" name="connection_form" value="1">
                <input type="hidden" name="solution" value="{{ $solutionKey }}">
                @if($errors->any())<div class="connection-errors" role="alert" tabindex="-1"><strong>Please check your details.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <div class="connection-questions">
                    <fieldset class="connection-question"><legend><span>1</span>What are your main reasons for seeking support at this time?</legend><p id="reasons-help">Select at least 3 options.</p><div class="connection-reason-options">
                        @foreach(config('development.connection.reasons') as $reason)<label><input type="checkbox" name="quick_questions[reasons][]" value="{{ $reason }}" @checked(in_array($reason, old('quick_questions.reasons', []))) aria-describedby="reasons-help"><span>{{ $reason }}</span></label>@endforeach
                    </div></fieldset>
                    <fieldset class="connection-question"><legend><span>2</span>How would you describe the current level of the selected areas?</legend><p>Select one option.</p><div class="connection-radio-options">
                        @foreach(config('development.connection.levels') as $level)<label><input type="radio" name="quick_questions[current_level]" value="{{ $level }}" required @checked(old('quick_questions.current_level') === $level)><span>{{ $level }}</span></label>@endforeach
                    </div></fieldset>
                    <fieldset class="connection-question"><legend><span>3</span>How soon would you like to get support?</legend><div class="connection-radio-options connection-timelines">
                        @foreach(config('development.connection.timelines') as $timeline)<label><input type="radio" name="quick_questions[timeline]" value="{{ $timeline }}" required @checked(old('quick_questions.timeline', config('development.connection.timelines.0')) === $timeline)><span>{{ $timeline }}</span></label>@endforeach
                    </div></fieldset>
                    <fieldset class="connection-question"><legend><span>4</span>What is the age of the person who needs support?</legend><div class="connection-input no-icon connection-age"><select id="age" name="age" required aria-label="Child’s age"><option value="">Select age</option>@foreach(range(5, 25) as $age)<option value="{{ $age }}" @selected((string) old('age') === (string) $age)>{{ $age }} years</option>@endforeach</select></div></fieldset>
                </div>
                <fieldset class="connection-account-fields"><legend>{{ $register ? 'Your Account Details' : 'Parent / Guardian Details' }}</legend>
                    <div class="connection-fields">
                        <div class="connection-field"><span class="connection-field-label" id="relationship-label">Are you a Parent or Guardian?</span><div class="connection-relationship" role="group" aria-labelledby="relationship-label">@foreach(['Parent' => 'user', 'Guardian' => 'user-shield'] as $relationship => $icon)<label><input type="radio" name="quick_questions[relationship]" value="{{ $relationship }}" required @checked(old('quick_questions.relationship', 'Parent') === $relationship)><span><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>{{ $relationship }}</span></label>@endforeach</div></div>
                        @if($register)
                            @foreach(['name' => ['Your Full Name', 'text', 'Enter your full name', 'name', 255], 'email' => ['Email Address', 'email', 'Enter your email address', 'email', 255], 'phone' => ['Phone Number', 'tel', 'Enter phone number', 'tel-national', 30], 'location' => ['Location (County / Town)', 'text', 'Enter your location', 'address-level2', 100], 'password' => ['Create Password', 'password', 'At least 12 characters', 'new-password', null], 'password_confirmation' => ['Confirm Password', 'password', 'Confirm your password', 'new-password', null]] as $field => [$label, $type, $placeholder, $autocomplete, $maximum])
                                <div class="connection-field"><label for="{{ $field }}">{{ $label }}</label><div class="connection-input no-icon">
                                    @if($field === 'phone')<select class="connection-country-code" name="country_code" aria-label="Phone country code">@foreach(['+254' => '🇰🇪 +254', '+256' => '+256', '+255' => '+255', '+250' => '+250', '+1' => '+1', '+44' => '+44'] as $code => $country)<option value="{{ $code }}" @selected(old('country_code', '+254') === $code)>{{ $country }}</option>@endforeach</select>@endif
                                    <input id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ $type === 'password' ? '' : old($field) }}" autocomplete="{{ $autocomplete }}" @required($field !== 'location') @if($maximum) maxlength="{{ $maximum }}" @endif @if($type === 'password') minlength="12" @endif aria-invalid="{{ $errors->has($field) ? 'true' : 'false' }}">
                                    @if($type === 'password')<button type="button" class="password-toggle" data-password-toggle="{{ $field }}" aria-controls="{{ $field }}" aria-label="Show {{ strtolower($label) }}" aria-pressed="false"><i class="fa-solid fa-eye-slash" aria-hidden="true"></i></button>@endif
                                </div></div>
                            @endforeach
                        @else
                            <p class="connection-account">Signed in as <strong>{{ auth()->user()->name }}</strong>. This child will be added to your account.</p>
                        @endif
                    </div>
                </fieldset>
                <details class="connection-child-details" @if($errors->hasAny(['child_name', 'grade', 'pwd_status', 'pwd_details', 'school', 'support_notes'])) open @endif><summary>Child profile — required before continuing</summary>
                <fieldset class="connection-child"><legend>Child’s Details</legend><div class="connection-fields">
                    <div class="connection-field"><label for="child_name">Child’s Full Name <span aria-hidden="true">*</span></label><div class="connection-input"><i class="fa-solid fa-user" aria-hidden="true"></i><input id="child_name" name="child_name" value="{{ old('child_name') }}" placeholder="Child’s full name" required maxlength="120" autocomplete="off"></div></div>
                    <div class="connection-field"><label for="grade">Grade / Level (CBE) <span aria-hidden="true">*</span></label><div class="connection-input"><i class="fa-solid fa-book-open" aria-hidden="true"></i><select id="grade" name="grade" required><option value="">Select grade/level</option>@foreach(['PP1', 'PP2', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12', 'College / University', 'Vocational training', 'Beyond school', 'Other'] as $grade)<option @selected(old('grade') === $grade)>{{ $grade }}</option>@endforeach</select></div></div>
                    <div class="connection-field"><label for="school">School <small>(Optional)</small></label><div class="connection-input"><i class="fa-solid fa-school" aria-hidden="true"></i><input id="school" name="school" value="{{ old('school') }}" placeholder="Enter school name" maxlength="150"></div></div>
                    <div class="connection-field"><label for="pwd_status">PWD Status <span aria-hidden="true">*</span></label><div class="connection-input"><i class="fa-solid fa-wheelchair" aria-hidden="true"></i><select id="pwd_status" name="pwd_status" required aria-describedby="pwd-help"><option value="">Select PWD status</option>@foreach(['no' => 'No', 'yes' => 'Yes', 'prefer_not_to_say' => 'Prefer not to say'] as $value => $label)<option value="{{ $value }}" @selected(old('pwd_status') === $value)>{{ $label }}</option>@endforeach</select></div><small id="pwd-help">Person with a disability.</small></div>
                    <div class="connection-field"><label for="pwd_details">If Yes, please specify <small>(Optional)</small></label><div class="connection-input no-icon"><input id="pwd_details" name="pwd_details" value="{{ old('pwd_details') }}" placeholder="e.g. visual, hearing, physical, learning" maxlength="250" @disabled(old('pwd_status') !== 'yes')></div></div>
                    <div class="connection-field full-width"><label for="support_notes">Tell Us More <small>(Optional)</small></label><div class="connection-input connection-textarea"><i class="fa-solid fa-comment-dots" aria-hidden="true"></i><textarea id="support_notes" name="support_notes" maxlength="500" rows="3" aria-describedby="notes-counter" placeholder="Share your child’s interests, current challenges, goals or any other information that will help us find the best support.">{{ old('support_notes') }}</textarea><output id="notes-counter" for="support_notes">{{ mb_strlen(old('support_notes', '')) }}/500</output></div></div>
                </div></fieldset>
                </details>
                @if($register)<label class="connection-consent"><input type="checkbox" name="terms" value="1" required @checked(old('terms'))><span>I agree to creating a family account and storing these details for support and assessment.</span></label>@endif
                <details class="connection-privacy"><summary>How we use your information</summary><p>Your account stores your child’s profile and assessment answers. Sharing with a provider requires separate confirmation. <a href="{{ route('contact') }}">Contact our team</a> to request changes or deletion.</p></details>
                <button type="submit" class="connection-submit">{{ $register ? 'Create Account & Continue' : 'Save Child & Begin Assessment' }} <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                @if($register)<p class="connection-login">Already have an account? <a href="{{ route('development.login', ['solution' => $solutionKey]) }}">Login here</a></p>@endif
            </form>
        </div>
    </section>
</main>
</body>
</html>
