<?php

namespace App\Http\Livewire\Users;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
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
        $this->dialog()->confirm([
            'title'       => 'Do you want to delete this user?',
            'description' => 'If you run this option, you will not be able to undo it.',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'delete',
        ]);
    }

    public function delete()
    {
        (new DeleteUser())->delete($this->user);

        $this->emitTo(All::class, 'users::deleted');

        $this->notification()->success('User deleted success');
    }
}
