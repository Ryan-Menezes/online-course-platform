<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use WireUi\Traits\Actions;

class All extends Component
{
    use Actions;

    public function render()
    {
        return view('livewire.roles.all');
    }
}
