<?php

namespace App\Http\Livewire\Roles;

use App\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use WireUi\Traits\Actions;

class Edit extends Component
{
    use Actions, AuthorizesRequests;

    public Role $role;

    public ?string $name = null;
    public ?string $label = null;
    public ?string $description = null;
    public array $permissions = [];

    public function mount(Role $role)
    {
        $this->authorize('update', $role);

        $this->role = $role;
        $this->name = $this->role->name;
        $this->label = $this->role->label;
        $this->description = $this->role->description;
        $this->permissions = $this->role->permissions()->pluck('name')->toArray();
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191', Rule::unique('roles')->ignore($this->role->id)],
            'label' => ['required', 'string', 'max:191'],
            'description' => ['required', 'string', 'max:300'],
        ];
    }

    public function render()
    {
        return view('livewire.roles.edit');
    }

    public function save()
    {
        $data = $this->validate();

        $this->role->update($data);
        $this->role->clearPermissions();
        $this->role->givePermissions($this->permissions);

        $this->notification()->success('Role updated success');
    }
}
