<div>
    <x-slot name="header">
        {{ __('Courses') }}
    </x-slot>

    <div class="relative">
        <div class="flex items-center justify-between pb-4 bg-white dark:bg-gray-900">
            @can(['courses-create', 'courses-edit', 'courses-delete'])
                <x-form.select-all-trash wire:model="filter" />
            @endcan

            <div class="flex items-center justify-end gap-5">
                @can('courses-create')
                    {{-- <livewire:courses.create /> --}}
                @endcan

                <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5">
            @foreach($this->courses as $course)
                <x-courses.card :course="$course" />
            @endforeach
        </div>

        <div class="mt-5">
            {{ $this->courses->links() }}
        </div>
    </div>
</div>
