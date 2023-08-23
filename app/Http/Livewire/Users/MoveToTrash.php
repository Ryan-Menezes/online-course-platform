<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use WireUi\Traits\Actions;

class MoveToTrash extends Component
{
    use Actions;

    public User $user;

    public function render()
    {
        return view('livewire.users.move-to-trash');
    }

    public function confirmMoveToTrash()
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to move this user to trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'moveToTrash',
            'params'      => 'Saved',
        ]);
    }

    public function moveToTrash()
    {
        $this->user->delete();

        $this->emitTo(All::class, 'users::trashed');

        $this->notification()->success(
            'User moved to trash success',
            'You can recover it if you want'
        );
    }
}
