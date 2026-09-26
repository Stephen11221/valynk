<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SitePageAdminController extends Controller
{
    private const PUBLIC_SLUGS = ['home', 'about', 'how-it-works', 'families', 'providers', 'institutions', 'pricing', 'contact', 'solutions'];

    public function index(): View
    {
        $pages = SitePage::query()->whereIn('slug', self::PUBLIC_SLUGS)->orderBy('slug')->get();

        return view('admin.content', compact('pages'));
    }

    public function edit(SitePage $sitePage): View
    {
        abort_unless(in_array($sitePage->slug, self::PUBLIC_SLUGS, true), 404);

        return view('admin.content-edit', compact('sitePage'));
    }

    public function update(Request $request, SitePage $sitePage): RedirectResponse
    {
        abort_unless(in_array($sitePage->slug, self::PUBLIC_SLUGS, true), 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'eyebrow' => ['nullable', 'string', 'max:255'],
            'heading' => ['required', 'string', 'max:500'],
            'intro' => ['required', 'string', 'max:2000'],
            'is_published' => ['required', 'boolean'],
        ]);

        $sitePage->update([
            'title' => $data['title'],
            'meta_description' => $data['meta_description'] ?? null,
            'content' => array_replace($sitePage->fresh()->content ?? [], [
                'eyebrow' => $data['eyebrow'] ?? '',
                'heading' => $data['heading'],
                'intro' => $data['intro'],
            ]),
            'is_published' => (bool) $data['is_published'],
        ]);

        return redirect()->route('admin.content')->with('status', 'Page saved.');
    }
}
