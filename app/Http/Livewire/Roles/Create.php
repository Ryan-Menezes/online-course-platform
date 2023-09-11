<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public $createModal = null;
    public ?string $name = null;
    public ?string $label = null;
    public ?string $description = null;
    public array $permissions = [];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191', 'unique:roles'],
            'label' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'max:300'],
        ];
    }

    public function render()
    {
        return view('livewire.roles.create');
    }

    public function save()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $data = $this->validate();

        $role = Role::query()->create($data);
        $role->givePermissions($this->permissions);

        $this->emitTo(All::class, 'roles::created');
        $this->notification()->success('Role created success');
        $this->resetExcept();
    }

    private function isAuthorizable()
    {
        if (Gate::allows('roles-create')) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
