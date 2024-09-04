<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">

            <!-- Header Title -->
            <h2 class="font-medium  text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

</x-app-layout>