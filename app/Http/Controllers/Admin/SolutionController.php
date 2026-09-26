<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitePage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SolutionController extends Controller
{
    public function index(): View
    {
        $solutions = (SitePage::query()->where('slug', 'solutions')->first() ?? new SitePage)->solutionDetails();

        return view('admin.solutions', compact('solutions'));
    }

    public function create(): View
    {
        return view('admin.solution-edit', ['solution' => null, 'details' => []]);
    }

    public function edit(string $solution): View
    {
        $solutions = (SitePage::query()->where('slug', 'solutions')->first() ?? new SitePage)->solutionDetails();
        abort_unless(isset($solutions[$solution]), 404);

        return view('admin.solution-edit', ['solution' => $solution, 'details' => $solutions[$solution]]);
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->save($request);
    }

    public function update(Request $request, string $solution): RedirectResponse
    {
        return $this->save($request, $solution);
    }

    private function save(Request $request, ?string $solution = null): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'max:1000'],
            'tagline' => ['nullable', 'string', 'max:150'],
            'age_range' => ['required', 'string', 'max:150'],
            'tone' => ['required', Rule::in(['pink', 'blue', 'green', 'gold', 'purple', 'teal', 'orange'])],
            'image_url' => ['nullable', 'url:https', 'max:2000'],
            'photo' => ['required', 'integer', 'between:0,7'],
            'support_intro' => ['required', 'string', 'max:500'],
            'highlights' => ['required', 'string', 'max:1000'],
            'benefits' => ['required', 'string', 'max:3000'],
            'cta_label' => ['required', 'string', 'max:80'],
            'cta_route' => ['required', Rule::in(['contact', 'register', 'development.landing', 'development.register'])],
            'is_published' => ['required', 'boolean'],
            'areas' => ['required', 'array', 'min:1', 'max:8'],
            'areas.*' => ['required', 'array:title,points,image_url'],
            'areas.*.title' => ['required', 'string', 'max:180'],
            'areas.*.points' => ['required', 'string', 'max:2000'],
            'areas.*.image_url' => ['nullable', 'url:https', 'max:2000'],
        ]);
        $data['image_url'] = $data['image_url'] ?? null;
        $data['tagline'] = $data['tagline'] ?? null;
        $data['highlights'] = $this->lines($data['highlights'], 'highlights', 4);
        $data['benefits'] = $this->lines($data['benefits'], 'benefits', 10);
        $data['is_published'] = (bool) $data['is_published'];
        $data['photo'] = (int) $data['photo'];
        $data['icon'] = 'star';
        $areas = [];
        foreach (array_values($data['areas']) as $index => $area) {
            $areas[] = [
                'title' => $area['title'],
                'points' => $this->lines($area['points'], "areas.$index.points", 8),
                'image_url' => $area['image_url'] ?? null,
                'photo' => $data['photo'],
                'tone' => ['pink', 'blue', 'green', 'purple'][$index % 4],
                'icon' => ['brain', 'bullseye', 'mountain', 'people-group'][$index % 4],
            ];
        }
        $data['areas'] = $areas;

        DB::transaction(function () use ($data, $solution): void {
            SitePage::query()->firstOrCreate(['slug' => 'solutions'], [
                'title' => 'Solutions | VALYNK', 'content' => [], 'is_published' => true,
            ]);
            $page = SitePage::query()->where('slug', 'solutions')->lockForUpdate()->firstOrFail();
            $solutions = $page->solutionDetails();
            if ($solution !== null) {
                abort_unless(isset($solutions[$solution]), 404);
                $data['icon'] = $solutions[$solution]['icon'];
                foreach ($data['areas'] as $index => &$area) {
                    $area['photo'] = $solutions[$solution]['areas'][$index]['photo'] ?? $data['photo'];
                }
                unset($area);
            } else {
                $solution = Str::slug($data['title']);
                if ($solution === '' || isset($solutions[$solution])) {
                    throw ValidationException::withMessages(['title' => 'Please use a unique solution title.']);
                }
            }
            $content = $page->content ?? [];
            $content['solutions'][$solution] = $data;
            $page->update(['content' => $content]);
        });

        return redirect()->route('admin.solutions.index')->with('status', 'Solution details saved.');
    }

    /** @return list<string> */
    private function lines(string $value, string $field, int $maximum): array
    {
        $lines = array_values(array_filter(array_map('trim', preg_split('/\R/u', $value)), fn (string $line): bool => $line !== ''));
        if (count($lines) < 1 || count($lines) > $maximum) {
            throw ValidationException::withMessages([$field => "Enter between 1 and $maximum items, one per line."]);
        }

        return $lines;
    }
}
