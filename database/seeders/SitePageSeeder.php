<?php

namespace Database\Seeders;

use App\Models\SitePage;
use Illuminate\Database\Seeder;

class SitePageSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $page) {
            SitePage::query()->firstOrCreate(
                ['slug' => $page['slug']],
                $page,
            );
        }
    }

    /**
     * @return list<array{slug: string, title: string, meta_description: string, content: array<string, string>, is_published: bool}>
     */
    private function pages(): array
    {
        return [
            ['slug' => 'home', 'title' => 'VALYNK | The link that delivers', 'meta_description' => 'Evidence-backed matching that delivers.', 'content' => ['eyebrow' => 'Evidence-backed matching that delivers', 'heading' => "The Right Connection.\nMeasurable Impact.", 'intro' => 'VALYNK connects people and organisations to the right expertise and opportunities through evidence-based matching, so every connection creates meaningful outcomes.'], 'is_published' => true],
            ['slug' => 'about', 'title' => 'About VALYNK | The link that delivers', 'meta_description' => 'Learn about VALYNK and the evidence-backed connections we create.', 'content' => ['eyebrow' => 'About VALYNK', 'heading' => 'The Link That Delivers', 'intro' => 'VALYNK was founded with a simple belief: every connection should create opportunity, drive impact, and deliver better outcomes.'], 'is_published' => true],
            ['slug' => 'how-it-works', 'title' => 'How It Works | VALYNK', 'meta_description' => "Discover VALYNK's evidence-backed six-step matching process.", 'content' => ['eyebrow' => 'How it works', 'heading' => 'Simple. Smart. Seamless.', 'intro' => 'VALYNK makes it easy to find the right support. Our evidence-backed matching process connects you with trusted experts and organisations so you can focus on what matters most.'], 'is_published' => true],
            ['slug' => 'families', 'title' => 'For Families | VALYNK', 'meta_description' => 'Find trusted child development support with VALYNK.', 'content' => ['heading' => "The right support.\nThe right time. The right impact.", 'intro' => 'VALYNK helps families find the right specialist support for your child, at every stage of growth and development.'], 'is_published' => true],
            ['slug' => 'providers', 'title' => 'For Providers | VALYNK', 'meta_description' => 'Grow your practice and impact with VALYNK.', 'content' => ['eyebrow' => 'For providers', 'heading' => 'Grow Your Impact. Expand Your Reach.', 'intro' => 'VALYNK connects you with the right people and organisations that need your expertise. Join a trusted network of verified Providers and grow your impact.'], 'is_published' => true],
            ['slug' => 'institutions', 'title' => 'For Institutions | VALYNK', 'meta_description' => 'Build stronger partnerships and better outcomes with VALYNK.', 'content' => ['eyebrow' => 'For institutions', 'heading' => 'Stronger Partnerships. Better Outcomes.', 'intro' => 'VALYNK connects you with verified experts and providers who help you deliver high-impact support to the children, students and communities you serve.'], 'is_published' => true],
            ['slug' => 'pricing', 'title' => 'Pricing | VALYNK', 'meta_description' => 'Simple, transparent VALYNK pricing for individuals, families, providers, and institutions.', 'content' => ['eyebrow' => 'Pricing', 'heading' => "Simple, Transparent Pricing.\nReal Value.", 'intro' => "Choose the plan that fits your needs. Whether you're an individual, a family, a Provider or an Institution, there's a VALYNK plan for you."], 'is_published' => true],
            ['slug' => 'contact', 'title' => 'Contact Us | VALYNK', 'meta_description' => 'Contact VALYNK for support, partnerships, and enquiries.', 'content' => ['eyebrow' => 'Contact us', 'heading' => "We're Here to Help.\nLet's Connect.", 'intro' => "Have a question, need support, or want to explore a partnership?\nReach out to us, we'd love to hear from you."], 'is_published' => true],
            ['slug' => 'solutions', 'title' => 'Solutions | VALYNK', 'meta_description' => 'Explore VALYNK solutions for individuals, institutions, providers, foundations and corporations.', 'content' => ['eyebrow' => 'Our solutions', 'heading' => "Different Needs.\nOne Powerful Approach.", 'intro' => 'VALYNK offers a range of solutions designed to help individuals, institutions and organisations unlock potential, build capability and achieve lasting results.'], 'is_published' => true],
            ['slug' => 'login', 'title' => 'Login | VALYNK', 'meta_description' => 'Log in to your VALYNK account.', 'content' => [], 'is_published' => true],
            ['slug' => 'register', 'title' => 'Create an Account | VALYNK', 'meta_description' => 'Create your VALYNK account.', 'content' => [], 'is_published' => true],
        ];
    }
}
