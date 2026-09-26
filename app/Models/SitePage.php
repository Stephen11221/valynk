<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        return array_replace(config('solutions'), $this->content['solutions'] ?? []);
    }

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'is_published' => 'boolean',
        ];
    }
}
