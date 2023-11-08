<div>
    <x-button rounded dark right-icon="plus" label="Add" onclick="$openModal('createModal')" />

    <x-modal.card title="Create Section" align="center" blur wire:model.defer="createModal">
        <x-sections.form />

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" wire:loading.attr="disabled" wire:target="save" />
                <x-button type="submit" form="form-section" primary label="Save" wire:loading.attr="disabled" wire:target="save" />
            </div>
        </x-slot>
    </x-modal.card>
</div>
