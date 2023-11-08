<h2 class="accordion-heading" data-id="accordion-section-{{ $section->id }}">
    <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 dark:border-gray-700 dark:text-gray-400 hover:bg-blue-100 dark:hover:bg-gray-800">
        <span>{{ $section->title }}</span>
        <svg class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
        </svg>
    </button>
</h2>
<div class="accordion-body hidden" id="accordion-section-{{ $section->id }}">
    <div class="p-6 flex flex-col gap-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
        <div class="flex justify-start items-center gap-5">
            <x-dropdown align="left">
                <x-dropdown.item icon="pencil" label="Edit" />
                <x-dropdown.item icon="trash" label="Delete" />
            </x-dropdown>

            <livewire:sections.active-toggle :section="$section" />
        </div>

        @forelse ($section->contents as $content)
            <x-contents.card :content="$content" />
        @empty
            <p>This section doesn't have any contents</p>
        @endforelse
    </div>
</div>
