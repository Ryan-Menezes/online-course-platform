<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
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
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to recover this role from trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'recoverFromTrash',
        ]);
    }

    public function recoverFromTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->role->restore();

        $this->emitTo(All::class, 'roles::recovered');

        $this->notification()->success('Role recovered from trash success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('restore', $this->role)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
