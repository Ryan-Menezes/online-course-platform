<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions, AuthorizesRequests;

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

    public function mount()
    {
        $this->authorize('courses-create');
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
        $data = $this->validate();

        $course = Course::query()->create([
            ...$data,
            'slug' => str($this->slug)->slug(),
            'active' => $this->active,
        ]);

        $this->notification()->confirm([
            'title' => 'Course created success',
            'icon' => 'success',
            'accept'      => [
                'label'  => 'Edit secions',
                'method' => 'redirectEdit',
                'params' => $course->id,
            ],
            'reject' => [
                'label' => 'Close',
            ],
        ]);

        $this->resetExcept();
    }

    public function redirectEdit($id)
    {
        $this->redirectRoute('courses.edit', ['course' => $id]);
    }
}
