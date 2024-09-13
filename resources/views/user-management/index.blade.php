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
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
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