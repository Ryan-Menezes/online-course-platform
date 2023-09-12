@props([
    'course'
])

<figure class="relative max-w-sm transition-all duration-300 cursor-pointer filter">
    <a href="#">
        <img class="rounded-lg h-60 object-cover object-center w-full contrast-75" src="{{ $course->thumb->url }}" alt="{{ $course->title }}">
    </a>
    <figcaption class="absolute px-4 text-lg text-white bottom-6 w-full">
        <h2 class="text-2xl mb-3 font-bold">{{ $course->title }}</h2>

        <p class="text-ellipsis overflow-hidden whitespace-nowrap w-full">{{ $course->description }}</p>

        <div class="flex justify-between items-center mt-4">
            <div class="flex">
                @can('courses-edit')
                    <div class="flex items-center mr-2">
                        <livewire:courses.active-toggle wire:key="active-toggle-{{ $course->id }}" :course="$course" />
                    </div>
                @endcan

                <div class="flex items-center">
                    <span>{{ $course->sections->count() }}</span>
                    <x-icon name="collection" class="w-5 h-5 ml-2" />
                </div>
                <div class="flex items-center ml-5">
                    <span>{{ $course->contents->count() }}</span>
                    <x-icon name="video-camera" class="w-5 h-5 ml-2" />
                </div>
            </div>
            <div class="flex items-center">
                @canany(['courses-edit', 'courses-delete'])
                    <x-dropdown align="right">
                        @can('courses-edit')
                            {{-- <x-dropdown.item icon="pencil" label="Edit" href="{{ route('courses.edit', $course) }}" /> --}}
                        @endcan

                        @can('courses-delete')
                            @if ($course->deleted_at)
                                <livewire:courses.delete wire:key="delete-{{ $course->id }}" :course="$course" />
                                <livewire:courses.recover-from-trash wire:key="recover-from-trash-{{ $course->id }}" :course="$course" />
                            @else
                                <livewire:courses.move-to-trash wire:key="move-to-trash-{{ $course->id }}" :course="$course" />
                            @endif
                        @endcan
                    </x-dropdown>
                @endcanany
            </div>
        </div>
    </figcaption>
</figure>
