<?php

namespace App\View\Components\Users;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.users.form');
    }
}
