<div>
    <x-slot name="header">
        {{ __('Users') }}
    </x-slot>

    <div class="relative">
        <div class="flex items-center justify-between pb-4 bg-white dark:bg-gray-900">
            @canany(['users-create', 'users-edit', 'users-delete'])
                <x-form.select-all-trash wire:model="filter" />
            @endcanany

            <div class="flex items-center justify-end gap-5">
                @can('users-create')
                    <livewire:users.create />
                @endcan

                <x-input icon="search" name="search" placeholder="Search" wire:model.lazy="search" />
            </div>
        </div>

        <x-table wire:loading.remove wire:target="filter, search">
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
                @foreach($this->users as $user)
                    <tr class="bg-white border-t dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <x-table.td class="font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center gap-5">
                            <x-avatar sm src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                            <span>{{ $user->name }}</span>
                        </x-table.td>
                        <x-table.td>
                            {{ $user->email }}
                        </x-table.td>
                        <x-table.td>
                            <x-badge rounded outline label="{{ $user->role->label }}" />
                        </x-table.td>
                        <x-table.td>
                            {{ $user->created_at }}
                        </x-table.td>
                        <x-table.td>
                            {{ $user->updated_at }}
                        </x-table.td>
                        <x-table.td>
                            @if ($user->deleted_at)
                                <x-badge icon="check" flat rounded positive label="Positive" />
                            @else
                                <x-badge icon="x" flat rounded negative label="Negative" />
                            @endif
                        </x-table.td>
                        <x-table.td>
                            @canany(['users-edit', 'users-delete'])
                                <x-dropdown align="right">
                                    @can('users-edit')
                                        <x-dropdown.item icon="pencil" label="Edit" href="{{ route('users.edit', $user) }}" />
                                    @endcan

                                    @can('users-delete')
                                        @if ($user->deleted_at)
                                            <livewire:users.delete wire:key="delete-{{ $user->id }}" :user="$user" />
                                            <livewire:users.recover-from-trash wire:key="recover-from-trash-{{ $user->id }}" :user="$user" />
                                        @else
                                            <livewire:users.move-to-trash wire:key="move-to-trash-{{ $user->id }}" :user="$user" />
                                        @endif
                                    @endcan
                                </x-dropdown>
                            @endcanany
                        </x-table.td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>

        <x-loading-spinner wire:loading wire:target="filter, search" />

        <div class="mt-5" wire:loading.remove wire:target="filter, search">
            {{ $this->users->links() }}
        </div>
    </div>
</div>
