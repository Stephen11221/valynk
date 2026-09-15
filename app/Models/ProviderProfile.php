<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderProfile extends Model
{
    protected $fillable = ['service', 'category', 'status', 'verification'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
