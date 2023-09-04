<?php

namespace App\Http\Livewire\Files;

use App\Models\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public File $file;

    public function render()
    {
        return view('livewire.files.delete');
    }

    public function confirmDelete()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Do you want to delete this file?',
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

        $path = $this->file->path;

        $this->file->forceDelete();

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $this->emitTo(All::class, 'files::deleted');

        $this->notification()->success('File deleted success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('forceDelete', $this->file)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
