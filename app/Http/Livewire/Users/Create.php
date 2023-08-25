<?php

namespace App\Http\Livewire\Users;

use App\Actions\Fortify\CreateNewUser;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;

    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;

    public function render()
    {
        return view('livewire.users.create');
    }

    public function save()
    {
        (new CreateNewUser())->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature()
        ]);

        $this->emitTo(All::class, 'users::created');

        $this->notification()->success('User created success');
    }
}
