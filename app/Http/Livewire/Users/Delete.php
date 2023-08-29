<?php

namespace App\Http\Livewire\Users;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public User $user;

    public function render()
    {
        return view('livewire.users.delete');
    }

    public function confirmDelete()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Do you want to delete this user?',
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

        (new DeleteUser())->delete($this->user);

        $this->emitTo(All::class, 'users::deleted');

        $this->notification()->success('User deleted success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('forceDelete', $this->user)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
