<?php

namespace App\Models;

use App\Models\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Content extends Model
{
    use HasFactory, FilterScope;

    private array $permissions = ['courses-create', 'courses-edit', 'courses-delete'];

    public function thumb(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_thumb_id');
    }

    public function video(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_video_id');
    }

    public function section(): HasOne
    {
        return $this->hasOne(Section::class);
    }

    public function course(): HasOne
    {
        return $this->section->course;
    }
}
