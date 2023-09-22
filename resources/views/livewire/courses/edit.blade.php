<div>
    <x-slot name="header">
        {{ __('Edit Course') }}
    </x-slot>

    <x-courses.form />

    <div class="flex justify-end gap-x-4 mt-6">
        <x-button type="submit" form="form-course" primary label="Save" wire:loading.attr="disabled" wire:target="save" />
    </div>

    <div class="block rounded-lg bg-white border mt-8 dark:bg-neutral-700">
        <h5 class="border-b-2 border-neutral-100 px-6 py-3 text-xl font-medium leading-tight dark:border-neutral-600 dark:text-neutral-50">
            Featured
        </h5>
        <div class="p-6 flex flex-col gap-5">
            <x-courses.contents.card />
            <x-courses.contents.card />
            <x-courses.contents.card />
        </div>
    </div>
</div>
