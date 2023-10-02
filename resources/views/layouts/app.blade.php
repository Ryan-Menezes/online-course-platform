<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite('resources/css/app.css')

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8 flex gap-4">
                        <x-navbar />

                        <x-card padding="p-6" class="bg-white sm:rounded-lg flex-initial w-full">
                            @if (isset($header))
                                <x-slot name="header">
                                    <div class="px-7 py-4 border-b">
                                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                            {{ $header }}
                                        </h2>
                                    </div>
                                </x-slot>
                            @endif

                            {{ $slot }}
                        </x-card>
                    </div>
                </div>
            </main>
        </div>

        @stack('modals')

        <x-notifications position="top-right" />
        <x-dialog z-index="z-50" blur="md" align="center" />

        @livewireScripts
        @wireUiScripts
        @vite('resources/js/app.js')

        @stack('scripts')
    </body>
</html>
