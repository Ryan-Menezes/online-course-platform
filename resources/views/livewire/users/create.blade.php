<div>
    <x-button primary rounded onclick="$openModal('createModal')">Novo</x-button>

    <x-modal.card title="Create User" align="center" blur wire:model.defer="createModal">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <x-input type="text" label="Name" placeholder="Name" name="name" id="name" wire:model.defer="name" />

            <x-input type="email" label="Email" placeholder="example@mail.com" name="email" id="email" icon="mail" wire:model.defer="email" />

            <div class="col-span-1 sm:col-span-2">
                <x-select-role wire:model.defer="role_id" />
            </div>

            <x-inputs.password label="Password" placeholder="Password" name="password" id="password" icon="lock-closed" wire:model.defer="password" />

            <x-inputs.password label="Password Confirmation" placeholder="Password" name="password_confirmation" id="password" icon="lock-closed" wire:model.defer="password_confirmation" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button primary label="Save" wire:click="save" />
            </div>
        </x-slot>
    </x-modal.card>
</div>
