<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SitePage extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'title',
        'meta_description',
        'content',
        'is_published',
    ];

    /** @return array<string, array<string, mixed>> */
    public function solutionDetails(): array
    {
        $solutions = array_replace(config('solutions'), $this->content['solutions'] ?? []);
        foreach ($solutions as &$details) {
            $details['display_image_url'] = ! empty($details['image_path'])
                ? Storage::disk('public')->url($details['image_path'])
                : ($details['image_url'] ?? null);
        }
        unset($details);

        return $solutions;
    }

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_published' => 'boolean',
        ];
    }
}
