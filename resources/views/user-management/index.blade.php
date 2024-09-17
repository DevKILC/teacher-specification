<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">
            <!-- Header Title -->
            <h2 class="font-medium text-2xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
        </div>
    </x-slot>

    <div>
    <div class="py-12 flex-col justify-center">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top section -->
            <div class="flex items-center text-left w-full h-16 mt-2 mb-6 bg-white py-5 rounded-md shadow-md">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                        <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                    </svg>
                </span>
                <h1 class="text-2xl">
                   User Management Data
                </h1>
            </div>

            

        </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Skill List -->
                @if($users->isEmpty())
                    <p>No User available.</p>
                @else
                <table class="table-auto py-10" id="users-table">
                    <thead  class="bg-yellow-400 text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2 flex space-x-2">
                                <a href="{{ route('user-management.edit-role', $user->id ) }}">
                                    <x-button class="text-white px-4 py-2 rounded-md">
                                        {{ __('EDIT ROLE') }}
                                    </x-button>
                                </a>
                                <a href="{{ route('user-management.edit-permission', $user->id ) }}">
                                    <x-button class="text-white px-4 py-2 rounded-md">
                                        {{ __('EDIT PERMISSION') }}
                                    </x-button>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            $('#users-table').DataTable();
        });
    </script>
</x-app-layout>