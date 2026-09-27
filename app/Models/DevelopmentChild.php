<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevelopmentChild extends Model
{
    protected $fillable = ['user_id', 'name', 'age', 'grade', 'school', 'solution', 'pwd_status', 'pwd_details', 'support_notes'];

    protected $hidden = ['pwd_status', 'pwd_details', 'support_notes'];

    protected function casts(): array
    {
        return ['pwd_status' => 'encrypted', 'pwd_details' => 'encrypted', 'support_notes' => 'encrypted'];
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(DevelopmentAssessment::class);
    }
}
