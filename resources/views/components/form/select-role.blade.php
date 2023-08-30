<x-select
    label="Role"
    placeholder="Select some role"
    option-label="label"
    option-value="id"
    {{ $attributes }}
>
    @foreach($roles() as $role)
        <x-select.option label="{{ $role->label }}" value="{{ $role->id }}" description="{{ $role->description }}" />
    @endforeach
</x-select>
