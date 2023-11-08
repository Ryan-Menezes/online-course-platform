<form method="POST" id="form-section" wire:submit.prevent="save">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="col-span-1 sm:col-span-2">
            <x-toggle md label="Active" wire:model.defer="active" id="section-active" />
        </div>

        <div class="col-span-1 sm:col-span-2">
            <x-input type="text" label="Titulo" placeholder="Titulo" wire:model.defer="title" />
        </div>
    </div>
</form>
