<x-select
    label="Role"
    placeholder="{{ ($role?->label ?? 'Select some role') }}"
    :options="$roles()"
    option-label="label"
    option-value="id"
    {{ $attributes }}
/>
