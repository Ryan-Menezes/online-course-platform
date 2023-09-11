<?php

namespace App\Http\Livewire\Files;

use App\Models\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class All extends Component
{
    use WithPagination, AuthorizesRequests;

    public $filter = null;

    public array $mimetypes = [];

    public $search = '';

    protected $queryString = [
        'filter' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    protected $listeners = [
        'files::created' => '$refresh',
        'files::trashed' => '$refresh',
        'files::recovered' => '$refresh',
        'files::deleted' => '$refresh',
    ];

    public function mount()
    {
        $this->authorize('files-view');
    }

    public function render()
    {
        return view('livewire.files.all');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingMimetypes()
    {
        $this->resetPage();
    }

    public function getFilesProperty()
    {
        return File::query()
            ->search($this->search)
            ->mimetypes($this->mimetypes)
            ->filter($this->filter)
            ->latest()
            ->paginate(8);
    }
}
