<?php

namespace Database\Seeders;

use App\Models\SitePage;
use Illuminate\Database\Seeder;

class SitePageSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('site-pages') as $page) {
            SitePage::query()->firstOrCreate(
                ['slug' => $page['slug']],
                $page,
            );
        }
    }
}
