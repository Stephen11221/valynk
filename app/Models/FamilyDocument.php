<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'family_folder_id', 'name', 'child_name', 'path', 'extension', 'size'])]
class FamilyDocument extends Model
{
    public function folder(): BelongsTo
    {
        return $this->belongsTo(FamilyFolder::class, 'family_folder_id');
    }

    protected function casts(): array
    {
        return ['size' => 'integer'];
    }
}
