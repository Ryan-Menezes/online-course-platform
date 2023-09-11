<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
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
        'users::created' => '$refresh',
        'users::trashed' => '$refresh',
        'users::recovered' => '$refresh',
        'users::deleted' => '$refresh',
    ];

    public function mount()
    {
        $this->authorize('viewAny', auth()->user());
    }

    public function render()
    {
        return view('livewire.users.all');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        return User::query()
            ->with('role')
            ->search($this->search)
            ->filter($this->filter)
            ->latest()
            ->paginate(10);
    }
}
