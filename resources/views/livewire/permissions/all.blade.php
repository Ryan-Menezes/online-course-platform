<div>
    <x-slot name="header">
        {{ __('Permissions') }}
    </x-slot>

    <div class="relative">
        <div class="flex items-center justify-end pb-4 bg-white dark:bg-gray-900">
            <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
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
                </tr>
            </x-table.thead>
            <tbody>
                @foreach($this->permissions as $permission)
                    <tr class="bg-white border-t dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <x-table.td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $permission->name }}
                        </x-table.td>
                        <x-table.td>
                            {{ $permission->label }}
                        </x-table.td>
                        <x-table.td>
                            {{ $permission->description }}
                        </x-table.td>
                        <x-table.td>
                            {{ $permission->created_at }}
                        </x-table.td>
                        <x-table.td>
                            {{ $permission->updated_at }}
                        </x-table.td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>

        <div class="mt-5">
            {{ $this->permissions->links() }}
        </div>
    </div>
</div>
