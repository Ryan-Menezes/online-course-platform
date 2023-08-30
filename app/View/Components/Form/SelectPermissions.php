<?php

namespace App\View\Components\Form;

use App\Models\Permission;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectPermissions extends Component
{
    public function permissions()
    {
        return Permission::query()->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.form.select-permissions');
    }
}
