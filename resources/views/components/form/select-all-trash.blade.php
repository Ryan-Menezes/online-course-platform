<x-select
    label="Filter"
    placeholder="Select one status"
    :options="[
        ['name' => 'All',  'id' => 'all', 'description' => 'All except those in the trash'],
        ['name' => 'Trash', 'id' => 'trash', 'description' => 'All in the trash'],
    ]"
    option-label="name"
    option-value="id"
    {{ $attributes }}
/>
