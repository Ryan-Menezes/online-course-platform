<div>
    <x-slot name="header">
        {{ __('Edit Role') }}
    </x-slot>

    <x-roles.form />

    <div class="flex justify-end gap-x-4 mt-6">
        <x-button type="submit" form="form-role" primary label="Save" />
    </div>
</div>
