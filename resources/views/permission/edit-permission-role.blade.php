<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">
            <!-- Header Title -->
            <h2 class="font-medium text-2xl text-gray-800 leading-tight">
                {{ __('Permission of Role') }} {{ $role->name }}
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
                <form action="{{ route('permission.update-role-permission' , $role->id ) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <table class="table-auto py-10" id="permissions-table">
                        <thead>
                            <tr>
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="permission-checkbox"
                                    {{ $permission->selected ? 'checked' : '' }}>
                                </td>
                                <th>ID</th>
                                <th>Name</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $permission)
                            <tr>
                            <td class="border px-4 py-2 text-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="permission-checkbox"
                                    {{ $permission->selected ? 'checked' : '' }}>
                                </td>
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2">{{ $permission['name'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Update Button -->
                    <div class="mt-4 w-full flex justify-end">
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
