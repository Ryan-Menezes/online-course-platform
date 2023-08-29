<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to move this user to trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'moveToTrash',
        ]);
    }

    public function moveToTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->user->delete();

        $this->emitTo(All::class, 'users::trashed');

        $this->notification()->success('User moved to trash success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('delete', $this->user)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
