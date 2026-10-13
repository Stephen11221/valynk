<link rel="stylesheet" href="{{ asset('css/support-chat.css') }}?v={{ filemtime(public_path('css/support-chat.css')) }}">
<div class="support-chat {{ $floating ? 'support-chat-floating' : '' }}" data-support-chat data-feed-url="{{ $feedUrl }}" data-send-url="{{ $sendUrl }}" data-is-support="{{ $isSupport ? 'true' : 'false' }}">
    @if($floating)
        <button class="support-chat-toggle" type="button" aria-expanded="false" aria-controls="support-chat-panel"><i class="fa-solid fa-comments" aria-hidden="true"></i> Chat with Support</button>
    @endif
    <section id="support-chat-panel" class="support-chat-panel" aria-labelledby="support-chat-title" @if($floating) hidden @endif>
        <header><div><h2 id="support-chat-title">{{ $chatTitle }}</h2><p>Replies from the VALYNK support team</p></div>@if($floating)<button type="button" data-chat-close aria-label="Close support chat">×</button>@endif</header>
        <div class="support-chat-log" role="log" aria-label="Support conversation" aria-live="polite" aria-relevant="additions"><p class="support-chat-empty">Start a conversation with our support team. Replies will appear here.</p></div>
        <p class="support-chat-status" role="status"></p>
        <form class="support-chat-form" action="{{ $sendUrl }}" method="POST">
            @csrf
            <label for="support-chat-body">Your message</label>
            <textarea id="support-chat-body" name="body" rows="3" maxlength="2000" required placeholder="How can we help?"></textarea>
            <div><small>Shows the latest 100 messages.</small><button type="submit">Send <span aria-hidden="true">→</span></button></div>
        </form>
        <noscript>Enable JavaScript to use support chat.</noscript>
    </section>
</div>
<script src="{{ asset('js/support-chat.js') }}?v={{ filemtime(public_path('js/support-chat.js')) }}" defer></script>
