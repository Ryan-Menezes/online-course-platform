<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Edit extends Component
{
    use Actions, AuthorizesRequests;

    public Course $course;

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
            'slug' => ['required', 'string', 'max:191', Rule::unique('courses')->ignore($this->course->id)],
            'description' => ['required', 'string', 'max:300'],
            'file_thumb_id' => ['required', 'exists:files,id'],
            'file_certificate_id' => ['required', 'exists:files,id'],
        ];
    }

    public function mount(Course $course)
    {
        $this->authorize('update', $course);

        $this->course = $course;
        $this->title = $this->course->title;
        $this->slug = $this->course->slug;
        $this->description = $this->course->description;
        $this->active = $this->course?->active ?? false;
        $this->file_thumb_id = $this->course->file_thumb_id;
        $this->file_certificate_id = $this->course->file_certificate_id;
    }

    public function render()
    {
        return view('livewire.courses.edit');
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

        $this->course->update([
            ...$data,
            'slug' => str($this->slug)->slug(),
            'active' => $this->active,
        ]);

        $this->notification()->success('Course updated success');
    }
}
