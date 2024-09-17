<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">
            <!-- Header Title -->
            <h2 class="font-medium text-2xl text-gray-800 leading-tight">
                {{ __('Permission of ') }} {{ $user->name }}
            </h2>
        </div>
    </x-slot>

    <div x-data="{ openAddPermissionModal: false }">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Skill List -->
                @if($permissions->isEmpty())
                    <p>No Permission available.</p>
                @else
                <form action="{{ route('user-management.update-permission' , $user->id ) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <table class="table-auto py-10" id="permissions-table">
                        <thead>
                            <tr>
                            <th class="flex space-x-2 items-center ">Select All <input class="ml-3" type="checkbox" id="select-all"></th>
                                <th>ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                                <td class="border px-4 py-2 text-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="permission-checkbox">
                                </td>
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2">{{ $permission->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Update Button -->
                    <div class="mt-4 flex justify-end w-full">
                        <x-button type="submit">
                            {{__('Update Selected')}}
                        </x-button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            $('#permissions-table').DataTable();

            // Select all checkboxes functionality
            document.getElementById('select-all').addEventListener('click', function() {
                let checkboxes = document.querySelectorAll('.permission-checkbox');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });
        });
    </script>
</x-app-layout>
