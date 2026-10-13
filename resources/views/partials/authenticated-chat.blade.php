@auth
    @if(auth()->user()->is_admin)
        <link rel="stylesheet" href="{{ asset('css/support-chat.css') }}?v={{ filemtime(public_path('css/support-chat.css')) }}">
        <div class="support-chat support-chat-floating"><a class="support-chat-toggle" href="{{ route('admin.chat.index') }}">Support Chat Inbox</a></div>
    @else
        @include('account.partials.support-chat', ['floating' => true, 'feedUrl' => route('account.chat.index'), 'sendUrl' => route('account.chat.store'), 'chatTitle' => 'Chat with Support', 'isSupport' => false])
    @endif
@endauth
