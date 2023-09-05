<?php

namespace App\Http\Livewire\Courses;

use App\Models\Course;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination, AuthorizesRequests;

    public $filter = null;

    public $search = '';

    protected $queryString = [
        'filter' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    protected $listeners = [
        'courses::created' => '$refresh',
        'courses::trashed' => '$refresh',
        'courses::recovered' => '$refresh',
        'courses::deleted' => '$refresh',
    ];

    public function mount()
    {
        $this->authorize('courses-view');
    }

    public function render()
    {
        return view('livewire.courses.all');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function getCoursesProperty()
    {
        return Course::query()
            ->when($this->search, function ($query) {
                $query
                    ->where('title', 'LIKE', "%{$this->search}%")
                    ->orWhere('description', 'LIKE', "%{$this->search}%");
            })
            ->filter($this->filter)
            ->with('thumb')
            ->latest()
            ->paginate(9);
    }
}
