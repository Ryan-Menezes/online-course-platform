<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination;

    public $filter = null;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $listeners = [
        'users::trashed' => '$refresh',
        'users::recovered' => '$refresh',
        'users::deleted' => '$refresh',
    ];

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
            ->when($this->search, function ($query) {
                $query
                    ->where('name', 'LIKE', "%{$this->search}%")
                    ->orWhere('email', 'LIKE', "%{$this->search}%");
            })
            ->when(!$this->filter, function ($query) {
                $query->withTrashed();
            })
            ->when($this->filter === 'trash', function ($query) {
                $query->onlyTrashed();
            })
            ->paginate(10);
    }
}
