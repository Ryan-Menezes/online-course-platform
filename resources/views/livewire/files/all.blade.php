<div>
    <x-slot name="header">
        {{ __('Files') }}
    </x-slot>

    <div class="relative">
        @can('files-create')
            <livewire:files.create />
        @endcan

        <div class="grid grid-cols-2 items-center pb-4 bg-white dark:bg-gray-900 mt-5">
            <div class="grid grid-cols-2 gap-5">
                @canany(['files-create', 'files-edit', 'files-delete'])
                    <x-form.select-all-trash wire:model="filter" />
                @endcanany

                <x-files.select-mimetypes wire:model="mimetypes" />
            </div>

            <div class="flex items-center justify-end gap-5">
                <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8" wire:loading.remove wire:target="filter, mimetypes, search">
            @foreach($this->files as $file)
                <x-files.card :file="$file" />
            @endforeach
        </div>

        <x-loading-spinner wire:loading wire:target="filter, mimetypes, search" />

        <div class="mt-10" wire:loading.remove wire:target="filter, mimetypes, search">
            {{ $this->files->links() }}
        </div>
    </div>
</div>
