<div>
    <x-slot name="header">
        {{ __('Roles') }}
    </x-slot>

    <div class="relative">
        <div class="flex items-center justify-between pb-4 bg-white dark:bg-gray-900">
            <x-form.select-all-trash wire:model="filter" />

            <div class="flex items-center justify-end gap-5">
                @can('roles-create')
                    <livewire:roles.create />
                @endcan

                <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
            </div>
        </div>

        <x-table>
            <x-table.thead>
                <tr>
                    <x-table.th>
                        Name
                    </x-table.th>
                    <x-table.th>
                        Label
                    </x-table.th>
                    <x-table.th>
                        Description
                    </x-table.th>
                    <x-table.th>
                        Created at
                    </x-table.th>
                    <x-table.th>
                        Updated at
                    </x-table.th>
                    <x-table.th>
                        Trashed
                    </x-table.th>
                    <x-table.th></x-table.th>
                </tr>
            </x-table.thead>
            <tbody>
                @foreach($this->roles as $role)
                    <tr class="bg-white border-t dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <x-table.td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $role->name }}
                        </x-table.td>
                        <x-table.td>
                            {{ $role->label }}
                        </x-table.td>
                        <x-table.td>
                            {{ $role->description }}
                        </x-table.td>
                        <x-table.td>
                            {{ $role->created_at }}
                        </x-table.td>
                        <x-table.td>
                            {{ $role->updated_at }}
                        </x-table.td>
                        <x-table.td>
                            @if ($role->deleted_at)
                                <x-icon name="check-circle" class="w-5 h-5 text-green-600" />
                            @else
                                <x-icon name="x-circle" class="w-5 h-5 text-red-600" />
                            @endif
                        </x-table.td>
                        <x-table.td>
                            <x-dropdown align="right">
                                @can('roles-edit')
                                    <x-dropdown.item icon="pencil" label="Edit" href="{{ route('roles.edit', $role) }}" />
                                @endcan

                                @can('roles-view')
                                    @if ($role->deleted_at)
                                        <livewire:roles.delete wire:key="delete-{{ $role->id }}" :role="$role" />
                                        <livewire:roles.recover-from-trash wire:key="recover-from-trash-{{ $role->id }}" :role="$role" />
                                    @else
                                        <livewire:roles.move-to-trash wire:key="move-to-trash-{{ $role->id }}" :role="$role" />
                                    @endif
                                @endcan
                            </x-dropdown>
                        </x-table.td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>

        <div class="mt-5">
            {{ $this->roles->links() }}
        </div>
    </div>
</div>
