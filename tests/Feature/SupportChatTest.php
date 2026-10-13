<?php

namespace Tests\Feature;

use App\Models\SupportMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupportChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_has_chat_box_and_messages_page_and_tab_are_removed(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);

        $this->actingAs($parent)->get(route('dashboard'))->assertOk()
            ->assertSee('Chat with Support')->assertSee(route('account.chat.store'))
            ->assertDontSee('tab-messages')->assertDontSee('/dashboard/messages');
        $this->get('/dashboard/messages')->assertNotFound();
        $this->get(route('account.family.documents'))->assertOk()->assertSee('Chat with Support');
    }

    public function test_parent_can_send_and_read_support_reply_without_exposing_another_conversation(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $otherParent = User::factory()->create(['account_type' => 'Family']);
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        SupportMessage::factory()->create(['user_id' => $otherParent->id, 'sender_id' => $otherParent->id, 'body' => 'Private conversation']);

        $this->actingAs($parent)->postJson(route('account.chat.store'), [
            'body' => 'Please help me find a solution.', 'user_id' => $otherParent->id, 'sender_id' => $admin->id,
        ])->assertCreated();
        $this->assertDatabaseHas('support_messages', ['user_id' => $parent->id, 'sender_id' => $parent->id, 'body' => 'Please help me find a solution.']);
        $this->actingAs($admin)->postJson(route('admin.chat.store', $parent), ['body' => 'We can help you choose.'])->assertCreated();
        $this->assertDatabaseHas('support_messages', ['user_id' => $parent->id, 'sender_id' => $admin->id, 'body' => 'We can help you choose.']);
        $this->actingAs($parent)->getJson(route('account.chat.index', ['user_id' => $otherParent->id]))->assertOk()
            ->assertJsonCount(2, 'messages')
            ->assertJsonPath('messages.0.body', 'Please help me find a solution.')
            ->assertJsonPath('messages.0.from_support', false)
            ->assertJsonPath('messages.1.body', 'We can help you choose.')
            ->assertJsonPath('messages.1.from_support', true)
            ->assertDontSee('Private conversation')
            ->assertHeader('Cache-Control', 'no-store, private');
    }

    public function test_admin_can_find_conversations_and_open_reply_box(): void
    {
        $parent = User::factory()->create(['name' => 'Parent with a question', 'account_type' => 'Family']);
        $noChat = User::factory()->create(['name' => 'Parent without a chat', 'account_type' => 'Family']);
        SupportMessage::factory()->create(['user_id' => $parent->id]);
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)->get(route('admin.chat.index'))->assertOk()
            ->assertSee('Parent with a question')->assertDontSee('Parent without a chat')
            ->assertSee(route('admin.chat.show', $parent));
        $this->get(route('admin.chat.show', $parent))->assertOk()->assertSee(route('admin.chat.store', $parent));
        $this->getJson(route('admin.chat.messages', $parent))->assertOk()->assertJsonCount(1, 'messages');
        $this->get(route('admin.chat.show', $noChat))->assertNotFound();
        $this->postJson(route('admin.chat.store', $noChat), ['body' => 'Hello'])->assertNotFound();
    }

    public function test_chat_requires_authentication_and_support_inbox_requires_admin(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $this->getJson(route('account.chat.index'))->assertUnauthorized();
        $this->postJson(route('account.chat.store'), ['body' => 'Hello'])->assertUnauthorized();
        $this->get(route('admin.chat.index'))->assertRedirect(route('login'));

        $this->actingAs($parent)->get(route('admin.chat.index'))->assertForbidden();
        $this->get(route('admin.chat.show', $parent))->assertForbidden();
        $this->getJson(route('admin.chat.messages', $parent))->assertForbidden();
        $this->postJson(route('admin.chat.store', $parent), ['body' => 'Fake support reply'])->assertForbidden();
        $this->assertDatabaseCount('support_messages', 0);
    }

    public function test_every_member_account_type_can_use_support_chat(): void
    {
        foreach (['Individual', 'Family', 'Provider', 'Institution', 'Partner / Other'] as $accountType) {
            $user = User::factory()->create(['account_type' => $accountType]);
            $this->actingAs($user)->get(route('dashboard'))->assertOk()->assertSee('data-support-chat', false);
            $this->postJson(route('account.chat.store'), ['body' => 'Hello from '.$accountType])->assertCreated();
            $this->getJson(route('account.chat.index'))->assertOk()
                ->assertJsonCount(1, 'messages')->assertJsonPath('messages.0.body', 'Hello from '.$accountType);
        }
        $this->assertDatabaseCount('support_messages', 5);
    }

    public function test_chat_is_available_once_on_public_and_journey_pages_after_login(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        $this->actingAs($parent);

        foreach (['home', 'about', 'families', 'providers', 'institutions', 'how-it-works', 'pricing', 'contact', 'solutions', 'development.landing', 'get-connected', 'development.home', 'development.child', 'development.providers', 'development.bookings', 'account.profile.edit', 'dashboard'] as $route) {
            $response = $this->get(route($route))->assertOk()
                ->assertSee('Chat with Support')->assertSee(route('account.chat.store'));
            $this->assertSame(1, substr_count($response->getContent(), 'data-support-chat data-feed-url='), $route);
        }
        $this->get(route('development.screens.show', 'child'))->assertOk()->assertSee('data-support-chat', false);
    }

    public function test_guests_do_not_see_chat_box_on_public_pages(): void
    {
        foreach (['home', 'about', 'contact', 'solutions', 'login', 'development.landing', 'get-connected'] as $route) {
            $this->get(route($route))->assertOk()->assertDontSee('data-support-chat', false)
                ->assertDontSee('Support Chat Inbox')->assertDontSee('support-chat.js');
        }
    }

    public function test_admin_has_support_inbox_shortcut_across_site_and_cannot_start_member_chat(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        foreach (['home', 'solutions', 'admin.dashboard', 'admin.chat.index'] as $route) {
            $this->actingAs($admin)->get(route($route))->assertOk()
                ->assertSee('Support Chat Inbox')->assertSee(route('admin.chat.index'))
                ->assertDontSee('data-support-chat', false);
        }
        $this->getJson(route('account.chat.index'))->assertForbidden();
        $this->postJson(route('account.chat.store'), ['body' => 'Hello'])->assertForbidden();
        $this->assertDatabaseCount('support_messages', 0);
    }

    public function test_chat_rejects_empty_and_oversized_messages_for_parent_and_support(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        SupportMessage::factory()->create(['user_id' => $parent->id]);
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        foreach (['', '   ', str_repeat('a', 2001)] as $body) {
            $this->actingAs($parent)->postJson(route('account.chat.store'), ['body' => $body])->assertUnprocessable()->assertJsonValidationErrors('body');
            $this->actingAs($admin)->postJson(route('admin.chat.store', $parent), ['body' => $body])->assertUnprocessable()->assertJsonValidationErrors('body');
        }
        $this->assertDatabaseCount('support_messages', 1);
    }

    public function test_chat_returns_latest_hundred_messages_in_chronological_order(): void
    {
        $parent = User::factory()->create(['account_type' => 'Family']);
        SupportMessage::factory()->create(['user_id' => $parent->id, 'body' => 'Older message']);
        SupportMessage::factory()->count(99)->create(['user_id' => $parent->id]);
        SupportMessage::factory()->create(['user_id' => $parent->id, 'body' => 'Newest message']);

        $this->actingAs($parent)->getJson(route('account.chat.index'))->assertOk()
            ->assertJsonCount(100, 'messages')->assertDontSee('Older message')
            ->assertJsonPath('messages.99.body', 'Newest message');
    }
}
