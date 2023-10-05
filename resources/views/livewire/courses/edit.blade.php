<div>
    <x-slot name="header">
        {{ __('Edit Course') }}
    </x-slot>

    <x-courses.form />

    <div class="flex justify-end gap-x-4 mt-6">
        <x-button type="submit" form="form-course" primary label="Save" wire:loading.attr="disabled" wire:target="save" />
    </div>

    <livewire:sections.all :course="$course" />
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
