@props([
    'file',
])

<div class="group relative">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none lg:h-80">
        <img src="{{ $file->url }}" alt="{{ $file->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full border">
    </div>
    <div class="mt-4 flex justify-between">
        <div>
            <h3 class="text-sm text-gray-700">
                {{ $file->name }}
            </h3>
            <p class="mt-1 text-sm text-gray-500">{{ $file->mimetype }}</p>
        </div>

        @can('files-delete')
            <x-dropdown align="right">
                @if ($file->deleted_at)
                    <livewire:files.delete wire:key="delete-{{ $file->id }}" :file="$file" />
                    <livewire:files.recover-from-trash wire:key="recover-from-trash-{{ $file->id }}" :file="$file" />
                @else
                    <livewire:files.move-to-trash wire:key="move-to-trash-{{ $file->id }}" :file="$file" />
                @endif
            </x-dropdown>
        @endcan
    </div>
</div>
