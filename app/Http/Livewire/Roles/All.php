<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
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
        'roles::created' => '$refresh',
        'roles::trashed' => '$refresh',
        'roles::recovered' => '$refresh',
        'roles::deleted' => '$refresh',
    ];

    public function mount()
    {
        $this->authorize('roles-view');
    }

    public function render()
    {
        return view('livewire.roles.all');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function getRolesProperty()
    {
        return Role::query()
            ->when($this->search, function ($query) {
                $query
                    ->where('name', 'LIKE', "%{$this->search}%")
                    ->orWhere('label', 'LIKE', "%{$this->search}%")
                    ->orWhere('description', 'LIKE', "%{$this->search}%");
            })
            ->filter($this->filter)
            ->latest()
            ->paginate(10);
    }
}
