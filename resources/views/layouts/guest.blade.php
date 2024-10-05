<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Teacher Data Specification</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body   x-init="window.addEventListener('beforeunload', () => { loading = true });
        window.addEventListener('pageshow', () => { loading = false })">

        {{-- loading  --}}
         <!-- loading line -->
    <div x-show="loading" class="fixed top-0 left-0 w-full z-[1000001]">
        <div class="h-1 bg-blue-500 animate-progress"></div>
    </div>
    <!-- Loading Spinner -->
    <div x-show="loading" x-cloak class="fixed top-4 right-4 z-[1000001]">
        <svg class="animate-spin h-4 w-4  text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
    </div>


        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
