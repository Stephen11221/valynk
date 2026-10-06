<dialog id="account-ready" class="account-ready" aria-labelledby="account-ready-title" aria-describedby="account-ready-description">
    <a class="account-ready-close" href="{{ route('dashboard') }}" aria-label="Go to dashboard"><i class="fa-solid fa-xmark" aria-hidden="true"></i></a>
    <div class="account-ready-layout">
        <aside class="account-ready-story">
            <img class="account-ready-photo" src="{{ asset('images/about/family.png') }}" alt="A family learning together">
            <img class="account-ready-logo" src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK">
            <div class="account-ready-story-copy"><span><i class="fa-solid fa-chart-column" aria-hidden="true"></i></span><h2>Next Step:<br>Your Personalised Assessment</h2><p>This short assessment helps us understand your specific needs so we can connect you with relevant support, providers and programmes.</p></div>
        </aside>
        <section class="account-ready-content">
            <div class="account-ready-check" aria-hidden="true"><i class="fa-solid fa-check"></i></div>
            <h1 id="account-ready-title">Your Account is Ready!</h1>
            <p id="account-ready-description">Thank you! Your account has been created and your initial information has been saved.</p>
            <div class="account-ready-solution"><i class="fa-solid fa-people-group" aria-hidden="true"></i><div><p>Selected Solution</p><strong>{{ $registeredSolutionTitle }}</strong></div></div>
            <section class="account-ready-next"><h2>What happens next?</h2><ol>
                @foreach([['Complete a short assessment', 'Answer a few questions to help us understand your child’s specific needs.'], ['Get your personalised report', 'Review key areas for support and recommended next steps.'], ['Explore providers & programmes', 'Use your results to explore relevant support options.']] as [$title, $description])
                    <li><span>{{ $loop->iteration }}</span><div><h3>{{ $title }}</h3><p>{{ $description }}</p></div></li>
                @endforeach
            </ol></section>
            <div class="account-ready-actions"><a href="{{ route('development.child.details', $child) }}" data-account-ready-continue autofocus>Start Assessment Now <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a><a href="{{ route('dashboard') }}"><i class="fa-solid fa-house" aria-hidden="true"></i> Go to Dashboard</a></div>
            <p class="account-ready-later">You can continue your assessment later from your dashboard.</p>
        </section>
    </div>
</dialog>
