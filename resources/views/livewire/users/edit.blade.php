<div>
    <x-slot name="header">
        {{ __('Edit User') }}
    </x-slot>

    <x-users.form />

    <div class="flex justify-end gap-x-4 mt-6">
        <x-button type="submit" form="form-user" primary label="Save" />
    </div>
</div>
