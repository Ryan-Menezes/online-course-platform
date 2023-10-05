<?php

namespace App\Http\Livewire\Sections;

use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class All extends Component
{
    use AuthorizesRequests;

    public Course $course;

    protected $listeners = [
        'sections::created' => '$refresh',
        'sections::deleted' => '$refresh',
    ];

    public function mount(Course $course)
    {
        $this->authorize('update', $course);
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.sections.all');
    }
}
