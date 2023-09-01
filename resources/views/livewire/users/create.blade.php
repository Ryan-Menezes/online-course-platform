<div>
    <x-button primary rounded onclick="$openModal('createModal')">Novo</x-button>

    <x-modal.card title="Create User" align="center" blur wire:model.defer="createModal">
        <x-users.form />

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" wire:loading.attr="disabled" wire:target="save" />
                <x-button type="submit" form="form-user" primary label="Save" wire:loading.attr="disabled" wire:target="save" />
            </div>
        </x-slot>
    </x-modal.card>
</div>
