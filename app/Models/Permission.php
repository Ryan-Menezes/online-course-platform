<?php

namespace App\Models;

use App\Models\Traits\FilterScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes, FilterScope;

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
