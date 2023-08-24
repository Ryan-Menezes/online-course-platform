<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public Role $role;

    public function render()
    {
        return view('livewire.roles.delete');
    }

    public function confirmDelete()
    {
        $this->dialog()->confirm([
            'title'       => 'Do you want to delete this role?',
            'description' => 'If you run this option, you will not be able to undo it.',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'delete',
        ]);
    }

    public function delete()
    {
        $this->role->forceDelete();

        $this->emitTo(All::class, 'roles::deleted');

        $this->notification()->success('Role deleted success');
    }
}
