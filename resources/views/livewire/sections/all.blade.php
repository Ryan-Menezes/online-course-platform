<div class="block rounded-lg bg-white border mt-8 dark:bg-neutral-700">
    <div class="border-b-2 border-neutral-100 px-6 py-3 flex justify-between items-center">
        <h5 class="text-xl font-medium leading-tight dark:border-neutral-600 dark:text-neutral-50">
            Sections
        </h5>
        <div class="flex justify-end items-center gap-5">
            <x-button rounded dark right-icon="plus" label="Add" />
        </div>
    </div>

    <div class="p-6">
        <div>
            @forelse($course->sections as $section)
                <x-sections.accordion :section="$section" />
            @empty
                <p>This course doesn't have any sections</p>
            @endforelse
        </div>
    </div>
</div>
