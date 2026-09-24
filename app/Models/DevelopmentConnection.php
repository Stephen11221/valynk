<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevelopmentConnection extends Model
{
    protected $fillable = ['user_id', 'provider_profile_id', 'development_child_id', 'status'];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(ProviderProfile::class, 'provider_profile_id');
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(DevelopmentChild::class, 'development_child_id');
    }
}
