<?php

namespace App\Http\Livewire\Permissions;

use App\Models\Permission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination, AuthorizesRequests;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        $this->authorize('permissions-view');
    }

    public function render()
    {
        return view('livewire.permissions.all');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function getPermissionsProperty()
    {
        return Permission::query()
            ->search($this->search)
            ->paginate(10);
    }
}
