<div>
    <x-slot name="header">
        {{ __('Edit Course') }}
    </x-slot>

    <x-courses.form />

    <div class="flex justify-end gap-x-4 mt-6">
        <x-button type="submit" form="form-course" primary label="Save" wire:loading.attr="disabled" wire:target="save" />
    </div>

    <div class="block rounded-lg bg-white border mt-8 dark:bg-neutral-700">
        <div class="border-b-2 border-neutral-100 px-6 py-3 flex justify-between items-center">
            <h5 class="text-xl font-medium leading-tight dark:border-neutral-600 dark:text-neutral-50">
                Seções
            </h5>
            <div class="flex justify-end items-center gap-5">
                <x-button.circle dark icon="plus" />
            </div>
        </div>

        <div class="p-6">
            <div>
                @forelse($course->sections as $section)
                    <x-courses.sections.accordion :section="$section" />
                @empty
                    <p>This course doesn't have any sections</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.querySelectorAll('.accordion-heading').forEach(accordionHeader => {
            accordionHeader.addEventListener('click', function () {
                const id = this.dataset.id;
                document.querySelector(`#${id}`).classList.toggle('hidden');
            });
        });
    </script>
@endpush
