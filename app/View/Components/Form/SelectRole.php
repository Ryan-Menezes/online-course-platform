<?php

namespace App\View\Components\Form;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectRole extends Component
{
    public function roles()
    {
        return Role::query()->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.form.select-role');
    }
}
