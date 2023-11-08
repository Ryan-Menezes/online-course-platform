<?php

namespace App\Http\Livewire\Sections;

use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Delete extends Component
{
    use Actions;

    public Section $section;

    public function render()
    {
        return view('livewire.sections.delete');
    }

    public function confirmDelete()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->dialog()->confirm([
            'title'       => 'Do you want to delete this section?',
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

        $this->section->delete();

        $this->emitTo(All::class, 'sections::deleted');

        $this->notification()->success('Section deleted success');
    }

    private function isAuthorizable()
    {
        if (Gate::allows('courses-delete')) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
