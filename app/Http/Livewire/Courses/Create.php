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
    public bool $active = true;
    public ?File $thumb = null;
    public ?File $certificate = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'slug' => ['required', 'string', 'max:191', 'unique:courses'],
            'description' => ['required', 'string', 'max:300'],
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
            'file_thumb_id' => $this->thumb->id,
            'file_certificate_id' => $this->certificate->id,
            ...$data,
        ]);

        $this->emitTo(All::class, 'courses::created');
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
