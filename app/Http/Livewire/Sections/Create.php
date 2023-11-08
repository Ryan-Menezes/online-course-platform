<?php

namespace App\Http\Livewire\Sections;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions, AuthorizesRequests;

    public Course $course;

    public $createModal = null;
    public ?string $title = null;
    public bool $active = false;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
        ];
    }

    public function render()
    {
        return view('livewire.sections.create');
    }

    public function save()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $data = $this->validate();

        $this->course->sections()->create([
            ...$data,
            'order' => Section::query()->orderBy('order')->first()?->order ?? 1,
            'active' => $this->active,
        ]);

        $this->emitTo(All::class, 'sections::created');
        $this->notification()->success('Section created success');
        $this->resetExcept(['course']);
    }

    private function isAuthorizable()
    {
        if (Gate::allows('create', $this->course)) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
