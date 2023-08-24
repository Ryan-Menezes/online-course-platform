<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Content extends Model
{
    use HasFactory;

    public function thumb(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_thumb_id');
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_video_id');
    }

    public function course(): HasOne
    {
        return $this->hasOne(Course::class);
    }
}
