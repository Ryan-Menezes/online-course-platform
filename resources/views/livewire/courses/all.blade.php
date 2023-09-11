<div>
    <x-slot name="header">
        {{ __('Courses') }}
    </x-slot>

    <div class="relative">
        <div class="flex items-center justify-between pb-4 bg-white dark:bg-gray-900">
            @canany(['courses-create', 'courses-edit', 'courses-delete'])
                <x-form.select-all-trash wire:model="filter" />
            @endcanany

            <div class="flex items-center justify-end gap-5">
                @can('courses-create')
                    <x-button primary rounded href="{{ route('courses.create') }}">Novo</x-button>
                @endcan

                <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5" wire:loading.remove wire:target="filter, search">
            @foreach($this->courses as $course)
                <x-courses.card :course="$course" />
            @endforeach
        </div>

        <x-loading-spinner wire:loading wire:target="filter, search" />

        <div class="mt-5" wire:loading.remove wire:target="filter, search">
            {{ $this->courses->links() }}
        </div>
    </div>
</div>
