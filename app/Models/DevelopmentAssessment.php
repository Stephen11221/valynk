<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevelopmentAssessment extends Model
{
    protected $fillable = ['development_child_id', 'answers', 'step', 'consented_at'];

    protected function casts(): array
    {
        return ['answers' => 'encrypted:array', 'consented_at' => 'datetime'];
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(DevelopmentChild::class, 'development_child_id');
    }
}
