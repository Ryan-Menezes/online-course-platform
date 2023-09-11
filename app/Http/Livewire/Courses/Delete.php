<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public Course $course;

    public function render()
    {
        return view('livewire.courses.delete');
    }

    public function confirmDelete()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Do you want to delete this course?',
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

        $this->course->forceDelete();

        $this->emitTo(All::class, 'courses::deleted');

        $this->notification()->success('Course deleted success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('forceDelete', $this->course)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
