<?php

namespace App\Models;

use App\Models\Traits\FilterScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes, FilterScope;

    private array $permissions = ['permissions-create', 'permissions-edit', 'permissions-delete'];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeSearch(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $query) use ($search) {
            $query
                ->where('name', 'LIKE', "%{$search}%")
                ->orWhere('label', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }
}
