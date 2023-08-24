<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use WireUi\Traits\Actions;

class RecoverFromTrash extends Component
{
    use Actions;

    public Role $role;

    public function render()
    {
        return view('livewire.roles.recover-from-trash');
    }

    public function confirmRecoverFromTrash()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to recover this role from trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'recoverFromTrash',
        ]);
    }

    public function recoverFromTrash()
    {
        $this->role->restore();

        $this->emitTo(All::class, 'roles::recovered');

        $this->notification()->success('Role recovered from trash success');
    }
}
