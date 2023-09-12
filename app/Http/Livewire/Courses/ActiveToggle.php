<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class ActiveToggle extends Component
{
    use Actions;

    public Course $course;

    protected $rules = [
        'course.active' => ['required', 'boolean'],
    ];

    public function render()
    {
        return view('livewire.courses.active-toggle');
    }

    public function updatedCourse()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->validate();

        $this->course->save();

        $this->notification()->success("Course #{$this->course->id} visibility changed");
    }

    private function isAuthorizable()
    {
        if (Gate::allows('courses-edit')) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
