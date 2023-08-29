<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
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
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Do you want to delete this role?',
            'description' => 'If you run this option, you will not be able to undo it.',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'delete',
        ]);
    }

    public function delete()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->role->forceDelete();

        $this->emitTo(All::class, 'roles::deleted');

        $this->notification()->success('Role deleted success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('forceDelete', $this->role)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
