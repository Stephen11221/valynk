<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'name'])]
class FamilyFolder extends Model
{
    public function documents(): HasMany
    {
        return $this->hasMany(FamilyDocument::class);
    }
}
