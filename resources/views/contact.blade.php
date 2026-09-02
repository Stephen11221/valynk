<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Contact VALYNK for support, partnerships, and enquiries.">
    <title>Contact Us | VALYNK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact-form.css') }}">
</head>
<body>
    @include('partials.navbar')

    <main id="top">
        <section class="contact-hero">
            <div>
                <p class="eyebrow">Contact us</p>
                <h1>We're Here to Help.<br>Let's Connect.</h1>
                <div class="rule"></div>
                <p>Have a question, need support, or want to explore a partnership?<br>Reach out to us, we'd love to hear from you.</p>
            </div>
            <div class="contact-photo" role="img" aria-label="Two people collaborating at a laptop"></div>
        </section>

        <section class="contact-grid">
            <form class="message-form">
                <h2>Send Us a Message</h2>
                <div class="form-fields">
                    <input type="text" placeholder="Your Name*" required>
                    <input type="email" placeholder="Email Address*" required>
                    <input type="tel" placeholder="Phone Number">
                    <select aria-label="I am..." name="audience">
                        <option value="" selected disabled>I am...</option>
                        <option value="individual">Individual</option>
                        <option value="family">For Family</option>
                        <option value="provider">For Provider</option>
                        <option value="institution">For Institution</option>
                        <option value="other">Others</option>
                    </select>
                    <input class="full" type="text" placeholder="Subject*" required>
                    <textarea class="full" placeholder="Your Message*" required></textarea>
                </div>
                <div class="form-actions">
                    <button class="button" type="submit">Send Message <i class="fa-solid fa-arrow-right"></i></button>
                    <small><i class="fa-solid fa-lock"></i> We respect your privacy. Your information is safe with us.</small>
                </div>
            </form>

            <aside class="reach-card">
                <h2>Other Ways to Reach Us</h2>
                <div>
                    <i class="fa-regular fa-envelope"></i>
                    <p><strong>Email</strong>hello@valynk.com</p>
                </div>
                <div>
                    <i class="fa-solid fa-phone"></i>
                    <p><strong>Phone</strong>+254 700 123 456</p>
                </div>
                <div>
                    <i class="fa-solid fa-location-dot"></i>
                    <p>
                        <strong>Office</strong>VALYNK HQ, 5th Floor, Westpoint Mall<br>
                        Mahiga Mairu Avenue, Westlands<br>
                        Nairobi, Kenya
                    </p>
                </div>
                <div>
                    <i class="fa-regular fa-clock"></i>
                    <p><strong>Business Hours</strong>Monday - Friday: 8:30 AM - 5:30 PM EAT</p>
                </div>
            </aside>

            <aside class="touch-card">
                <h2>Get in Touch About</h2>
                <a href="#">
                    <i class="fa-regular fa-envelope"></i>
                    <span>
                        <strong>General Enquiries</strong>
                        Questions about VALYNK
                    </span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
                <a href="#">
                    <i class="fa-solid fa-phone"></i>
                    <span>
                        <strong>Partnerships</strong>
                        Work with us
                    </span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
                <a href="#">
                    <i class="fa-solid fa-users"></i>
                    <span>
                        <strong>Provider Support</strong>
                        Join or get help as a Provider
                    </span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
                <a href="#">
                    <i class="fa-solid fa-building-columns"></i>
                    <span>
                        <strong>Institution Enquiries</strong>
                        Solutions for your organisation
                    </span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </aside>
        </section>

        <section class="contact-assurances">
            <article>
                <i class="fa-solid fa-headset"></i>
                <div>
                    <strong>Quick Response</strong>
                    <p>We aim to respond within 24 business hours.</p>
                </div>
            </article>
            <article>
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <strong>Trusted &amp; Secure</strong>
                    <p>Your information is kept safe and confidential.</p>
                </div>
            </article>
            <article>
                <i class="fa-solid fa-people-group"></i>
                <div>
                    <strong>Human Support</strong>
                    <p>Real people ready to help you succeed.</p>
                </div>
            </article>
            <article>
                <i class="fa-solid fa-globe"></i>
                <div>
                    <strong>Global Reach</strong>
                    <p>Local support with a global outlook.</p>
                </div>
            </article>
            <article>
                <i class="fa-solid fa-award"></i>
                <div>
                    <strong>Impact Focused</strong>
                    <p>We're committed to making a real difference.</p>
                </div>
            </article>
        </section>
    </main>
@include('partials.footer')
</body></html>