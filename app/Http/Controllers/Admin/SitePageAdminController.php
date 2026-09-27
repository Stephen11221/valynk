<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SitePageAdminController extends Controller
{
    public function index(): View
    {
        $saved = SitePage::query()->whereIn('slug', array_keys(config('site-pages')))->get()->keyBy('slug');
        $pages = collect(config('site-pages'))->except('solutions')->map(fn (array $defaults, string $slug): SitePage => $saved->get($slug) ?? new SitePage($defaults));

        return view('admin.content', compact('pages'));
    }

    public function edit(SitePage $sitePage): View
    {
        abort_unless(array_key_exists($sitePage->slug, config('site-pages')), 404);

        return view('admin.content-edit', compact('sitePage'));
    }

    public function editPage(string $slug): View
    {
        abort_unless(array_key_exists($slug, config('site-pages')), 404);
        $sitePage = SitePage::where('slug', $slug)->first() ?? new SitePage(config('site-pages.'.$slug));
        $sitePage->content = array_replace(config('site-pages.'.$slug.'.content', []), $sitePage->content ?? []);

        return view('admin.content-edit', compact('sitePage'));
    }

    public function updatePage(Request $request, string $slug): RedirectResponse
    {
        abort_unless(array_key_exists($slug, config('site-pages')), 404);
        $sitePage = SitePage::where('slug', $slug)->first() ?? new SitePage(config('site-pages.'.$slug));

        return $this->update($request, $sitePage);
    }

    public function update(Request $request, SitePage $sitePage): RedirectResponse
    {
        abort_unless(array_key_exists($sitePage->slug, config('site-pages')), 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'heading' => ['required', 'string', 'max:500'],
            'intro' => ['required', 'string', 'max:2000'],
            'is_published' => ['required', 'boolean'],
        ]);

        DB::transaction(function () use ($sitePage, $data): void {
            SitePage::query()->firstOrCreate(['slug' => $sitePage->slug], config('site-pages.'.$sitePage->slug));
            $sitePage = SitePage::query()->where('slug', $sitePage->slug)->lockForUpdate()->firstOrFail();
            $sitePage->update([
                'title' => $data['title'],
                'meta_description' => $data['meta_description'] ?? null,
                'content' => array_replace($sitePage->content ?? [], [
                    'eyebrow' => $data['eyebrow'] ?? '',
                    'heading' => $data['heading'],
                    'intro' => $data['intro'],
                ]),
                'is_published' => (bool) $data['is_published'],
            ]);
        });

        return redirect()->route($sitePage->slug === 'solutions' ? 'admin.solutions.index' : 'admin.content')->with('status', 'Page saved.');
    }
}
