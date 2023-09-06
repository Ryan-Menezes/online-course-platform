<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class MoveToTrash extends Component
{
    use Actions;

    public Course $course;

    public function render()
    {
        return view('livewire.courses.move-to-trash');
    }

    public function confirmMoveToTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to move this course to trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'moveToTrash',
        ]);
    }

    public function moveToTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->course->delete();

        $this->emitTo(All::class, 'courses::trashed');

        $this->notification()->success('Course moved to trash success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('delete', $this->course)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
