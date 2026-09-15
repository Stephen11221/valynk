<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $this->actingAs($admin);
    }

    /**
     * Test admin overview dashboard renders successfully.
     */
    public function test_admin_dashboard_overview_loads(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Overview');
        $response->assertSee('Platform Activity');
        $response->assertSee('Matches Overview');
        $response->assertSee('Top Performing Categories');
    }

    /**
     * Test user management page loads and filters correctly.
     */
    public function test_admin_users_page_loads(): void
    {
        $user = User::factory()->create([
            'account_type' => 'Family',
            'phone' => '0700000000',
            'location' => 'Nairobi',
        ]);
        $provider = User::factory()->create(['account_type' => 'Provider']);

        $response = $this->get(route('admin.users'));

        $response->assertStatus(200);
        $response->assertSee('Accounts');
        $response->assertSee('Families');
        $response->assertSee($user->name);
        $response->assertSee($provider->name);
        $response->assertSee('Family');
        $response->assertSee(route('admin.users.create'));
        $response->assertSee('href="'.route('admin.users').'"', false);
    }

    public function test_admin_can_add_a_user_with_a_selected_account_type(): void
    {
        $this->get(route('admin.users.create'))
            ->assertOk()
            ->assertSee('Select account type')
            ->assertSee('Individual')
            ->assertSee('Family')
            ->assertSee('Provider')
            ->assertSee('Institution')
            ->assertSee('Partner / Other');

        $this->post(route('admin.users.store'), [
            'name' => 'New Provider',
            'email' => 'new-provider@example.com',
            'phone' => '0712345678',
            'account_type' => 'Provider',
            'location' => 'Nairobi',
            'password' => 'a-secure-password',
            'password_confirmation' => 'a-secure-password',
            'is_admin' => '1',
        ])->assertRedirect(route('admin.users'));

        $user = User::query()->where('email', 'new-provider@example.com')->firstOrFail();
        $this->assertSame('New Provider', $user->name);
        $this->assertSame('Provider', $user->account_type);
        $this->assertSame('Nairobi', $user->location);
        $this->assertFalse($user->is_admin);
        $this->assertTrue(Hash::check('a-secure-password', $user->password));
        $this->get(route('admin.users', ['role' => 'provider']))->assertSee('New Provider');
    }

    public function test_add_user_rejects_duplicate_email_and_unknown_type(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $this->post(route('admin.users.store'), [
            'name' => 'Invalid User',
            'email' => 'existing@example.com',
            'account_type' => 'Unknown',
            'password' => 'a-secure-password',
            'password_confirmation' => 'a-secure-password',
        ])->assertSessionHasErrors(['email', 'account_type']);

        $this->assertSame(1, User::query()->where('email', 'existing@example.com')->count());
    }

    public function test_admin_user_management_can_create_and_edit_an_admin_account(): void
    {
        $this->post(route('admin.users.store'), [
            'name' => 'Staff Admin',
            'email' => 'staff-admin@example.test',
            'account_type' => 'Admin',
            'password' => 'strong-staff-password',
            'password_confirmation' => 'strong-staff-password',
        ])->assertRedirect(route('admin.users'));

        $staff = User::where('email', 'staff-admin@example.test')->firstOrFail();
        $this->assertTrue($staff->is_admin);
        $this->get(route('admin.users', ['role' => 'admin']))->assertSee('Staff Admin');
        $this->get(route('admin.users.edit', $staff))->assertSee('value="Admin" selected', false);

        $this->put(route('admin.users.update', $staff), [
            'name' => 'Staff Admin Updated',
            'email' => 'staff-admin@example.test',
            'account_type' => 'Admin',
        ])->assertRedirect(route('admin.users'));
        $this->assertSame('Staff Admin Updated', $staff->fresh()->name);
        $this->assertTrue($staff->fresh()->is_admin);
    }

    public function test_admin_can_remove_staff_access_but_cannot_remove_their_own(): void
    {
        $staff = User::factory()->create(['account_type' => 'Admin']);
        $staff->forceFill(['is_admin' => true])->save();

        $this->put(route('admin.users.update', $staff), [
            'name' => $staff->name,
            'email' => $staff->email,
            'account_type' => 'Individual',
        ])->assertRedirect(route('admin.users'));
        $this->assertFalse($staff->fresh()->is_admin);

        $currentAdmin = auth()->user();
        $this->put(route('admin.users.update', $currentAdmin), [
            'name' => $currentAdmin->name,
            'email' => $currentAdmin->email,
            'account_type' => 'Individual',
        ])->assertSessionHasErrors('account_type');
        $this->assertTrue($currentAdmin->fresh()->is_admin);
    }

    /**
     * Test that an administrator can update every editable user field.
     */
    public function test_admin_can_edit_a_user_account(): void
    {
        $user = User::factory()->create([
            'account_type' => 'Individual',
            'phone' => '0711111111',
            'location' => 'Nairobi',
        ]);

        $response = $this->put(route('admin.users.update', $user), [
            'name' => 'Updated Institution',
            'email' => 'institution@example.com',
            'phone' => '0722222222',
            'account_type' => 'Institution',
            'location' => 'Mombasa',
            'password' => 'new-secure-password',
            'password_confirmation' => 'new-secure-password',
        ]);

        $response->assertRedirect(route('admin.users'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Institution',
            'email' => 'institution@example.com',
            'account_type' => 'Institution',
            'location' => 'Mombasa',
        ]);
    }

    /**
     * Test evidence matches page loads correctly.
     */
    public function test_admin_matches_page_loads(): void
    {
        $response = $this->get(route('admin.matches'));

        $response->assertStatus(200);
        $response->assertSee('Evidence-Backed Matching Ledger');
        $response->assertSee('M-1001');
    }

    /**
     * Test analytics page loads correctly.
     */
    public function test_admin_analytics_page_loads(): void
    {
        $response = $this->get(route('admin.analytics'));

        $response->assertStatus(200);
        $response->assertSee('Analytics & Impact Metrics');
        $response->assertSee('Total System Volume');
    }

    /**
     * Test provider management page loads correctly.
     */
    public function test_admin_providers_page_loads(): void
    {
        $provider = User::factory()->create(['name' => 'Real Provider', 'account_type' => 'Provider']);
        $provider->providerProfile()->create([
            'service' => 'Tutoring', 'category' => 'Academic Support',
            'status' => 'Approved', 'verification' => 'Verified',
        ]);

        $response = $this->get(route('admin.providers'));

        $response->assertStatus(200);
        $response->assertSee('Provider Management');
        $response->assertSee('Real Provider');
        $response->assertSee('Academic Support');
        $response->assertSee('Providers by Status');
        $response->assertSee('Verification Overview');
    }

    /**
     * Test settings page loads correctly.
     */
    public function test_admin_settings_page_loads(): void
    {
        $response = $this->get(route('admin.settings'));

        $response->assertStatus(200);
        $response->assertSee('System Settings');
        $response->assertSee('General Settings');
        $response->assertSee('System Status');
    }

    /**
     * Test transaction management page loads correctly.
     */
    public function test_admin_transactions_page_loads(): void
    {
        $response = $this->get(route('admin.transactions'));

        $response->assertStatus(200);
        $response->assertSee('Transaction Management');
        $response->assertSee('All Transactions');
    }

    /**
     * Test payments page loads correctly.
     */
    public function test_admin_payments_page_loads(): void
    {
        $response = $this->get(route('admin.payments'));

        $response->assertStatus(200);
        $response->assertSee('Payment Management');
        $response->assertSee('All Transactions');
    }

    /**
     * Test subscriptions page loads correctly.
     */
    public function test_admin_subscriptions_page_loads(): void
    {
        $response = $this->get(route('admin.subscriptions'));

        $response->assertStatus(200);
        $response->assertSee('Subscriptions Management');
        $response->assertSee('All Subscriptions');
    }

    /**
     * Test content management page loads correctly.
     */
    public function test_admin_content_page_loads(): void
    {
        $response = $this->get(route('admin.content'));

        $response->assertStatus(200);
        $response->assertSee('Content Management');
        $response->assertSee('All Content');
    }

    /**
     * Test reports and analytics page loads correctly.
     */
    public function test_admin_reports_page_loads(): void
    {
        $response = $this->get(route('admin.reports'));

        $response->assertStatus(200);
        $response->assertSee('Reports & Analytics');
        $response->assertSee('Platform Overview');
    }

    /**
     * Test communications page loads correctly.
     */
    public function test_admin_communications_page_loads(): void
    {
        $response = $this->get(route('admin.communications'));

        $response->assertStatus(200);
        $response->assertSee('Communications Management');
        $response->assertSee('Recent Communications');
    }

    /**
     * Test audit logs page loads correctly.
     */
    public function test_admin_audit_logs_page_loads(): void
    {
        $response = $this->get(route('admin.audit-logs'));

        $response->assertStatus(200);
        $response->assertSee('Audit Logs');
        $response->assertSee('Audit Log Entries');
        $response->assertSee('Updated content item');
    }
}
