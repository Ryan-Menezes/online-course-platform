<?php

namespace App\Models;

use App\Models\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes, FilterScope;

    public function thumb(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_thumb_id');
    }

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_certificate_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function contents(): HasManyThrough
    {
        return $this->hasManyThrough(Content::class, Section::class);
    }
}
