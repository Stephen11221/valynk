<?php

namespace App\Http\Controllers;

use App\Models\SitePage;
use Illuminate\View\View;

class SitePageController extends Controller
{
    /**
     * @var array<string, string>
     */
    private const VIEWS = [
        'home' => 'welcome',
        'about' => 'about',
        'how-it-works' => 'how-it-works',
        'families' => 'families',
        'providers' => 'providers',
        'institutions' => 'institutions',
        'pricing' => 'pricing',
        'contact' => 'contact',
        'solutions' => 'solutions',
        'login' => 'login',
        'register' => 'register',
    ];

    public function show(string $slug): View
    {
        abort_unless(array_key_exists($slug, self::VIEWS), 404);

        $page = SitePage::query()
            ->where('slug', $slug)
            ->first();

        abort_if($page && ! $page->is_published, 404);

        return view(self::VIEWS[$slug], compact('page'));
    }
}
