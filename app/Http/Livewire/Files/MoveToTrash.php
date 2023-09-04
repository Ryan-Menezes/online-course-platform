<?php

namespace App\Http\Livewire\Files;

use App\Models\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class MoveToTrash extends Component
{
    use Actions;

    public File $file;

    public function render()
    {
        return view('livewire.files.move-to-trash');
    }

    public function confirmMoveToTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to move this file to trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'moveToTrash',
        ]);
    }

    public function moveToTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->file->delete();

        $this->emitTo(All::class, 'files::trashed');

        $this->notification()->success('File moved to trash success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('delete', $this->file)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
