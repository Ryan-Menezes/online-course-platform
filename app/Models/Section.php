<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Section extends Model
{
    use HasFactory;

    public function course(): HasOne
    {
        return $this->hasOne(Course::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
