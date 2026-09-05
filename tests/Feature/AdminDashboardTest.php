<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
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
        $response = $this->get(route('admin.users'));

        $response->assertStatus(200);
        $response->assertSee('User & Entity Management');
        $response->assertSee('Dr. Elena Rostova');
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
        $response = $this->get(route('admin.providers'));

        $response->assertStatus(200);
        $response->assertSee('Provider Management');
        $response->assertSee('MindWell Center');
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
        $response->assertSee('Platform Configuration & Algorithm Weights');
    }
}
