<div>
    <x-slot name="header">
        {{ __('Files') }}
    </x-slot>

    <div class="relative">
        <livewire:files.create />

        <div class="grid grid-cols-2 items-center pb-4 bg-white dark:bg-gray-900 mt-5">
            <div class="grid grid-cols-2 gap-5">
                <x-form.select-all-trash wire:model="filter" />
                <x-files.select-mimetypes wire:model="mimetypes" />
            </div>

            <div class="flex items-center justify-end gap-5">
                <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @foreach($this->files as $file)
                <x-files.card :file="$file" />
            @endforeach
        </div>

        <div class="mt-10">
            {{ $this->files->links() }}
        </div>
    </div>
</div>
