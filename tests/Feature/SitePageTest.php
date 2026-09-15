<?php

namespace Tests\Feature;

use App\Models\SitePage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_published_page_uses_content_from_the_database(): void
    {
        SitePage::query()->create([
            'slug' => 'about',
            'title' => 'Dynamic About | VALYNK',
            'meta_description' => 'A database-backed page description.',
            'content' => [
                'eyebrow' => 'Dynamic label',
                'heading' => 'A Dynamic About Page',
                'intro' => 'This copy was loaded from the site_pages table.',
            ],
            'is_published' => true,
        ]);

        $response = $this->get(route('about'));

        $response->assertOk();
        $response->assertSee('Dynamic About | VALYNK');
        $response->assertSee('A Dynamic About Page');
        $response->assertSee('This copy was loaded from the site_pages table.');
    }

    public function test_a_page_without_a_record_keeps_its_default_content(): void
    {
        $this->get(route('contact'))
            ->assertOk()
            ->assertSee("We're Here to Help.");
    }
}
