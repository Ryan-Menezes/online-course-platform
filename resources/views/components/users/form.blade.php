<form method="POST" id="form-user" wire:submit.prevent="save">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-input type="text" label="Name" placeholder="Name" wire:model.defer="name" />

        <x-input type="email" label="Email" placeholder="example@mail.com" icon="mail" wire:model.defer="email" />

        <div class="col-span-1 sm:col-span-2">
            <x-form.select-role wire:model.defer="role_id" />
        </div>

        <x-inputs.password label="Password" placeholder="Password" icon="lock-closed" wire:model.defer="password" />

        <x-inputs.password label="Password Confirmation" placeholder="Password" icon="lock-closed" wire:model.defer="password_confirmation" />
    </div>
</form>
