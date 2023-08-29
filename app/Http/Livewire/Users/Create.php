<?php

namespace App\Http\Livewire\Users;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions, PasswordValidationRules;

    public $createModal = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $role_id = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => $this->passwordRules(),
        ];
    }

    public function render()
    {
        return view('livewire.users.create');
    }

    public function save()
    {
        if (!$this->isAuthorizable()) {
            return;
        }

        $data = $this->validate();

        (new CreateNewUser())->create([
            ...$data,
            'password_confirmation' => $this->password_confirmation,
            'terms' => true,
        ]);

        $this->emitTo(All::class, 'users::created');
        $this->notification()->success('User created success');
        $this->reset();
    }

    private function isAuthorizable()
    {
        if (Gate::allows('create', auth()->user())) {
            return true;
        }

        $this->dialog()->error('You do not have authorization to perform this action');

        return false;
    }
}
