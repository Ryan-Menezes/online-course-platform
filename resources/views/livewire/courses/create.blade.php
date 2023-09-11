<div>
    <x-slot name="header">
        {{ __('Create Course') }}
    </x-slot>

    <x-courses.form />

    <div class="flex justify-end gap-x-4 mt-6">
        <x-button type="submit" form="form-course" primary label="Save" wire:loading.attr="disabled" wire:target="save" />
    </div>
</div>
