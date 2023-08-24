<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;
use WireUi\Traits\Actions;

class MoveToTrash extends Component
{
    use Actions;

    public Role $role;

    public function render()
    {
        return view('livewire.roles.move-to-trash');
    }

    public function confirmMoveToTrash()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to move this role to trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'moveToTrash',
        ]);
    }

    public function moveToTrash()
    {
        $this->role->delete();

        $this->emitTo(All::class, 'roles::trashed');

        $this->notification()->success('Role moved to trash success');
    }
}
