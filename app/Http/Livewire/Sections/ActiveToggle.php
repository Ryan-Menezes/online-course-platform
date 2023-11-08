<?php

namespace App\Http\Livewire\Sections;

use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class ActiveToggle extends Component
{
    use Actions;

    public Section $section;

    protected $rules = [
        'section.active' => ['required', 'boolean'],
    ];

    public function render()
    {
        return view('livewire.sections.active-toggle');
    }

    public function updatedSection()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $this->validate();

        $this->section->save();

        $this->notification()->success("Section #{$this->section->id} visibility changed");
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
