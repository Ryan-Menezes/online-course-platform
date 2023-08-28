<div>
    <x-button primary rounded onclick="$openModal('createModal')">Novo</x-button>

    <x-modal.card title="Create User" align="center" blur wire:model.defer="createModal">
        <x-users.form />
    </x-modal.card>
</div>
