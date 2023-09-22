<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Gate;

class ActiveScope implements Scope
{
    public function apply(Builder $query, Model $model): void
    {
        $query
            ->when(
                !Gate::any($model->permissions ?? []),
                function (Builder $query) {
                    $query
                        ->where('active', true);
                }
            );
    }
}
