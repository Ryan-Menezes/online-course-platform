<?php

namespace App\Http\Livewire\Files;

use App\Models\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class RecoverFromTrash extends Component
{
    use Actions;

    public File $file;

    public function render()
    {
        return view('livewire.files.recover-from-trash');
    }

    public function confirmRecoverFromTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to recover this file from trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'recoverFromTrash',
        ]);
    }

    public function recoverFromTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->file->restore();

        $this->emitTo(All::class, 'files::recovered');

        $this->notification()->success('File recovered from trash success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('restore', $this->file)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
