<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use App\Models\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public ?string $title = null;
    public ?string $slug = null;
    public ?string $description = null;
    public bool $active = false;
    public ?string $file_thumb_id = null;
    public ?string $file_certificate_id = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'slug' => ['required', 'string', 'max:191', 'unique:courses'],
            'description' => ['required', 'string', 'max:300'],
            'file_thumb_id' => ['required', 'exists:files,id'],
            'file_certificate_id' => ['required', 'exists:files,id'],
        ];
    }

    public function render()
    {
        return view('livewire.courses.create');
    }

    public function updatedTitle()
    {
        if (!$this->slug) {
            $this->slug = str($this->title)->slug();
        }
    }

    public function save()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $data = $this->validate();

        Course::query()->create([
            ...$data,
            'slug' => str($this->slug)->slug(),
            'active' => $this->active,
        ]);

        $this->notification()->success('Course created success');
        $this->resetExcept();
    }

    private function isAuthorizable()
    {
        if (Gate::allows('courses-create')) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
