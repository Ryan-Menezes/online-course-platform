<form method="POST" id="form-role" wire:submit.prevent="save">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <x-input type="text" label="Name" placeholder="Name" wire:model.defer="name" />

        <x-input type="text" label="Label" placeholder="Label" wire:model.defer="label" />

        <div class="col-span-1 sm:col-span-2">
            <x-form.select-permissions wire:model.defer="permissions" class="mb-4" />

            <x-textarea label="Description" placeholder="Description" wire:model="description" />
        </div>
    </div>
</form>
