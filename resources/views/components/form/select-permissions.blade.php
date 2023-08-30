<x-select
    label="Role"
    placeholder="Select some role"
    multiselect
    option-label="label"
    option-value="name"
    icon="lock-closed"
    {{ $attributes }}
>
    @foreach($permissions() as $permission)
        <x-select.option label="{{ $permission->label }}" value="{{ $permission->name }}" description="{{ $permission->description }}" />
    @endforeach
</x-select>
