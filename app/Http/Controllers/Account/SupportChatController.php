<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportChatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorizeMember($request->user());

        return $this->conversation($request->user());
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorizeMember($request->user());

        return $this->saveMessage($request, $request->user());
    }

    public function adminIndex(): View
    {
        $parents = User::query()->whereHas('supportMessages')
            ->withMax('supportMessages', 'id')->orderByDesc('support_messages_max_id')->paginate(20);

        return view('admin.support-chat', compact('parents'));
    }

    public function adminShow(User $user): View
    {
        abort_unless($user->supportMessages()->exists(), 404);

        return view('admin.support-chat', ['parent' => $user]);
    }

    public function adminMessages(User $user): JsonResponse
    {
        abort_unless($user->supportMessages()->exists(), 404);

        return $this->conversation($user);
    }

    public function adminStore(Request $request, User $user): JsonResponse
    {
        abort_unless($user->supportMessages()->exists(), 404);

        return $this->saveMessage($request, $user);
    }

    private function authorizeMember(User $user): void
    {
        abort_if($user->is_admin, 403);
    }

    private function saveMessage(Request $request, User $user): JsonResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'max:2000']]);
        $message = $user->supportMessages()->create([
            'sender_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        return response()->json(['id' => $message->id], 201);
    }

    private function conversation(User $user): JsonResponse
    {
        $messages = $user->supportMessages()->orderByDesc('id')->limit(100)->get()->reverse()->values()
            ->map(fn (SupportMessage $message): array => [
                'id' => $message->id,
                'body' => $message->body,
                'from_support' => $message->sender_id !== $user->id,
                'sent_at' => $message->created_at->toIso8601String(),
            ]);

        return response()->json(['messages' => $messages])->header('Cache-Control', 'private, no-store');
    }
}
