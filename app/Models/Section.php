<?php

namespace App\Models;

use App\Models\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes, FilterScope;

    public function course(): HasOne
    {
        return $this->hasOne(Course::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}