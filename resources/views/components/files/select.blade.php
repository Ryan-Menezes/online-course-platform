@props([
    'label' => 'Files',
    'placeholder' => 'Select files',
])

<x-select
    label="{{ $label }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes }}
>
    @foreach($files() as $file)
        <x-select.user-option src="{{ $file->thumb }}" label="{{ $file->name }}" value="{{ $file->id }}" />
    @endforeach
</x-select>
