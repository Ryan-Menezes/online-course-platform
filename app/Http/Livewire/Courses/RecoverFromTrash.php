<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class RecoverFromTrash extends Component
{
    use Actions;

    public Course $course;

    public function render()
    {
        return view('livewire.courses.recover-from-trash');
    }

    public function confirmRecoverFromTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => 'Do you want to recover this course from trash?',
            'acceptLabel' => 'Yes, i do',
            'method'      => 'recoverFromTrash',
        ]);
    }

    public function recoverFromTrash()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->course->restore();

        $this->emitTo(All::class, 'courses::recovered');

        $this->notification()->success('Course recovered from trash success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('restore', $this->course)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
