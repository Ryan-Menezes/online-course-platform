<?php

namespace App\View\Components\Form;

use App\Models\Role;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectRole extends Component
{
    public ?Role $role = null;

    public function __construct(string|Role $role = null)
    {
        $this->role = is_string($role) ? Role::query()->find($role) : $role;
    }

    public function roles(): array
    {
        return Role::query()->select('id', 'label')->get()->toArray();
    }

    public function render(): View|Closure|string
    {
        return view('components.form.select-role');
    }
}
