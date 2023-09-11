<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

trait FilterScope
{
    public function scopeFilter(Builder $query, ?string $filter): void
    {
        $query
            ->when(
                Gate::any($this->permissions ?? []),
                function ($query) use ($filter) {
                    $query
                        ->when(!$filter, function ($query) {
                            $query->withTrashed();
                        })
                        ->when($filter === 'trash', function ($query) {
                            $query->onlyTrashed();
                        });
                }
            );
    }
}
