<div>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="relative">
        <div class="flex items-center justify-between pb-4 bg-white dark:bg-gray-900">
            <x-select
                label="Filter"
                placeholder="Select one status"
                :options="[
                    ['name' => 'All',  'id' => 'all', 'description' => 'All users except those in the trash'],
                    ['name' => 'Trash', 'id' => 'trash', 'description' => 'All users in the trash'],
                ]"
                option-label="name"
                option-value="id"
                wire:model="filter"
            />

            <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
        </div>

        <x-table>
            <x-table.thead>
                <tr>
                    <x-table.th>
                        Name
                    </x-table.th>
                    <x-table.th>
                        E-mail
                    </x-table.th>
                    <x-table.th>
                        Role
                    </x-table.th>
                    <x-table.th>
                        Trashed
                    </x-table.th>
                    <x-table.th></x-table.th>
                </tr>
            </x-table.thead>
            <tbody>
                @foreach($this->users as $user)
                    <tr class="bg-white border-t dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <x-table.td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </x-table.td>
                        <x-table.td>
                            {{ $user->email }}
                        </x-table.td>
                        <x-table.td>
                            <x-badge rounded positive label="Admin" />
                        </x-table.td>
                        <x-table.td>
                            @if ($user->deleted_at)
                                <x-icon name="check-circle" class="w-5 h-5 text-green-600" />
                            @else
                                <x-icon name="x-circle" class="w-5 h-5 text-red-600" />
                            @endif
                        </x-table.td>
                        <x-table.td>
                            <x-dropdown align="left">
                                <x-dropdown.item icon="pencil" label="Edit" />

                                @if ($user->deleted_at)
                                    <x-dropdown.item icon="trash" label="Delete" wire:click="delete" />
                                    <x-dropdown.item icon="refresh" label="Recover from trash" wire:click="delete" />
                                @else
                                    <livewire:users.move-to-trash :key="$user->id" :user="$user" />
                                @endif
                            </x-dropdown>
                        </x-table.td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>

        <div class="mt-5">
            {{ $this->users->links() }}
        </div>
    </div>

    @push('modals')
        <x-dialog z-index="z-50" blur="md" align="center" />
    @endpush
</div>
