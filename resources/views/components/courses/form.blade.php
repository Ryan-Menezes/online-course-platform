<form method="POST" id="form-course" wire:submit.prevent="save">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="col-span-1 sm:col-span-2">
            <x-toggle md label="Active" wire:model.defer="active" />
        </div>

        <x-input type="text" label="Title" placeholder="Title" wire:model.lazy="title" />

        <x-input type="text" label="Slug" placeholder="Slug" wire:model.defer="slug" />

        <x-files.select label="Thumb" placeholder="Select a thumb" mimetype="image" wire:model.defer="file_thumb_id" />

        <x-files.select label="Certificate" placeholder="Select a certificate" wire:model.defer="file_certificate_id" />

        <div class="col-span-1 sm:col-span-2">
            <x-textarea label="Description" placeholder="Description" wire:model="description" />
        </div>
    </div>
</form>
