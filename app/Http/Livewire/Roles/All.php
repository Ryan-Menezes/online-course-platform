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
        'search' => ['except' => ''],
    ];

    protected $listeners = [
        'roles::trashed' => '$refresh',
        'roles::recovered' => '$refresh',
        'roles::deleted' => '$refresh',
    ];

    public function mount()
    {
        $this->authorize('viewAny', auth()->user());
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
            ->when(!$this->filter, function ($query) {
                $query->withTrashed();
            })
            ->when($this->filter === 'trash', function ($query) {
                $query->onlyTrashed();
            })
            ->latest()
            ->paginate(10);
    }
}
