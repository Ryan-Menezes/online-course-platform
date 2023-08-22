<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class All extends Component
{
    use Actions, WithPagination;

    public string $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        return view('livewire.users.all');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        return User::query()->when($this->search, function ($query) {
            $query->where('name', 'LIKE', "%{$this->search}%");
        })->paginate(10);
    }

    public function moveToTrash()
    {
        $this->dialog()->success(
            'Profile saved',
            'Your profile was successfully saved'
        );
    }
}
