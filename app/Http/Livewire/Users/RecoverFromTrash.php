<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class RecoverFromTrash extends Component
{
    use Actions;

    public User $user;

    public function render()
    {
        return view('livewire.users.recover-from-trash');
    }

    public function confirmRecoverFromTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to recover this user from trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'recoverFromTrash',
        ]);
    }

    public function recoverFromTrash()
    {

        if (!$this->isAuthorizable()) {
            return;
        }

        $this->user->restore();

        $this->emitTo(All::class, 'users::recovered');

        $this->notification()->success('User recovered from trash success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('restore', $this->user)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
