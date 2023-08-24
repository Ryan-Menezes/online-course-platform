<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public function thumb(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_thumb_id');
    }

    public function certificate(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_certificate_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
