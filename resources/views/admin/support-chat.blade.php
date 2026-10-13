@extends('layouts.admin')
@section('title', 'Support Chat')
@section('header_title', 'Support Chat')
@section('header_subtitle', 'Read member conversations and reply from the support team.')
@section('content')
    @isset($parent)
        <p><a href="{{ route('admin.chat.index') }}">← Back to support inbox</a></p>
        @include('account.partials.support-chat', ['floating' => false, 'feedUrl' => route('admin.chat.messages', $parent), 'sendUrl' => route('admin.chat.store', $parent), 'chatTitle' => 'Chat with '.$parent->name, 'isSupport' => true])
    @else
        <section class="rounded-xl border border-slate-200 bg-white p-5">
            <h2 class="text-lg font-bold">Support conversations</h2>
            @forelse($parents as $parent)
                <a class="flex items-center justify-between gap-4 border-b border-slate-200 py-4" href="{{ route('admin.chat.show', $parent) }}"><span>{{ $parent->name }}<small class="block text-slate-500">{{ $parent->email }}</small></span><span>Open Chat →</span></a>
            @empty
                <p class="mt-4 text-slate-500">No support conversations yet. New member chats will appear here.</p>
            @endforelse
            <div class="mt-4">{{ $parents->links() }}</div>
        </section>
    @endisset
@endsection
