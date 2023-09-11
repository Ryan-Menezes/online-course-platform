<?php

namespace App\Http\Livewire\Files;

use App\Models\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions, WithFileUploads;

    public $files = [];

    protected function rules(): array
    {
        return [
            'files' => 'required',
            'files.*' => 'file',
        ];
    }

    public function render()
    {
        return view('livewire.files.create');
    }

    public function save()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->validate();
        $this->uploadAndSaveFiles();

        $this->emitTo(All::class, 'files::created');
        $this->notification()->success('Files created success');
        $this->resetExcept();
    }

    private function uploadAndSaveFiles(): void
    {
        foreach ($this->files as $file) {
            $path = date('m-Y');
            $name = $file->getClientOriginalName();
            $name = Storage::fileExists("{$path}/{$name}") ? (md5(time() . uniqid()) . '-' . $name) : $name;
            $mimetype = $file->getMimeType();
            $path = $file->storeAs($path, $name, 'public');

            File::query()->create([
                'name' => $name,
                'mimetype' => $mimetype,
                'path' => $path,
            ]);
        }
    }

    private function isAuthorizable()
    {
        if (Gate::allows('files-create')) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
