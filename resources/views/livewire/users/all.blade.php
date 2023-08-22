<div>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="relative">
        <div class="flex items-center justify-between pb-4 bg-white dark:bg-gray-900">
            <x-dropdown align="left">
                <x-slot name="trigger">
                    <x-button rightIcon="chevron-down" rounded label="Options" default />
                </x-slot>

                <x-dropdown.item icon="users" label="All" />
                <x-dropdown.item icon="trash" label="Trash" />
            </x-dropdown>

            <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
        </div>

        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        E-mail
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->users as $user)
                    <tr class="bg-white border-t dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            <x-badge rounded positive label="Admin" />
                        </td>
                        <td class="px-6 py-4">
                            <x-dropdown align="left">
                                <x-dropdown.item icon="pencil" label="Edit" />
                                <x-dropdown.item icon="trash" label="Move to trash" wire:click="moveToTrash" />
                            </x-dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-5">
            {{ $this->users->links() }}
        </div>
    </div>

    @push('modals')
        <x-dialog z-index="z-50" blur="md" align="center" />
    @endpush
</div>
