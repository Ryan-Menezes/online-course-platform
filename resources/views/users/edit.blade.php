<x-app-layout>
    <x-slot name="header">
        {{ __('Edit User') }}
    </x-slot>

    <livewire:users.edit :user="$user" />
</x-app-layout>
