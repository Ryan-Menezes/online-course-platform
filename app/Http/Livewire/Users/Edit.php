<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Livewire\Component;
use WireUi\Traits\Actions;

class Edit extends Component
{
    use Actions, AuthorizesRequests;

    public User $user;

    public ?string $name = null;
    public ?string $email = null;
    public ?string $role_id = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    public function mount(User $user)
    {
        $this->authorize('update', $user);

        $this->user = $user;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role_id = $this->user->role_id;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')->ignore($this->user->id)],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', new Password, 'confirmed'],
        ];
    }

    public function render()
    {
        return view('livewire.users.edit');
    }

    public function save()
    {
        $data = $this->validate();

        $this->user->update([
            ...$data,
            'password' => $data['password'] ? Hash::make($data['password']) : $this->user->password,
        ]);

        $this->notification()->success('User updated success');
        $this->reset('password', 'password_confirmation');
    }
}
