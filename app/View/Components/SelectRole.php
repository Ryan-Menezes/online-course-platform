<?php

namespace App\View\Components;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectRole extends Component
{
    public function roles()
    {
        return Role::query()->select('id', 'label')->get()->toArray();
    }

    public function render(): View|Closure|string
    {
        return view('components.select-role');
    }
}
