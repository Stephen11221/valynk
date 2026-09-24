<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevelopmentChild extends Model
{
    protected $fillable = ['user_id', 'name', 'age', 'grade', 'school'];

    public function assessments(): HasMany
    {
        return $this->hasMany(DevelopmentAssessment::class);
    }
}
