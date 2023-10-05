<div class="flex rounded-lg bg-white border border-slate-300 dark:bg-neutral-700 max-h-40">
    <img class="h-auto w-40 !rounded-none !rounded-l-lg object-cover object-center" src="https://tecdn.b-cdn.net/wp-content/uploads/2020/06/vertical.jpg" alt="" />

    <div class="flex items-center justify-between p-6 w-full">
        <div>
            <h5 class="mb-2 text-xl font-medium text-neutral-800 dark:text-neutral-50">
                {{ $content->title }}
            </h5>
            <p class="mb-4 text-base text-neutral-600 dark:text-neutral-200">{{ $content->description }}</p>
            <p class="text-xs text-neutral-500 dark:text-neutral-300">
                {{ $content->created_at->diffForHumans() }}
            </p>
        </div>
        <div class="flex flex-col justify-between items-end h-full">
            <x-dropdown>
                <x-dropdown.item icon="pencil" label="Edit" />
                <x-dropdown.item icon="trash" label="Delete" />
            </x-dropdown>

            <x-toggle id="active-toggle-content-id-{{ $section->id }}" md wire:model.defer="active" />
        </div>
    </div>
</div>
