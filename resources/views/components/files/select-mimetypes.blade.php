<x-select
    label="Types"
    placeholder="Select mimetypes"
    :options="$mimetypes()"
    option-label="mimetype"
    option-value="mimetype"
    multiselect
    {{ $attributes }}
/>
