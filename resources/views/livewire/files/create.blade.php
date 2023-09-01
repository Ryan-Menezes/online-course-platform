<div>
    <x-input type="file" multiple wire:model="files" label="Files" name="files">
        <x-slot name="append">
            <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                <x-button
                    class="h-full rounded-r-md"
                    icon="upload"
                    primary
                    flat
                    squared
                    wire:click="save"
                    wire:loading.attr="disabled"
                    wire:target="save"
                />
            </div>
        </x-slot>
    </x-input>
</div>
