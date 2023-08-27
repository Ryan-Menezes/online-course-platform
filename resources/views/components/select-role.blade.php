<x-select
    label="Role"
    placeholder="Select some role"
    :options="$roles()"
    option-label="label"
    option-value="id"
    {{ $attributes }}
/>
