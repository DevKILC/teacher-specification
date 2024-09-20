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
                <!-- Permission List -->
                @if($permissions->isEmpty())
                    <p>No Permission available.</p>
                @else
                <form id="permissionsForm" action="{{ route('user-management.update-permission' , $user->id ) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <table class="table-auto py-10" id="permissionsTable">
                        <thead>
                            <tr>
                                <th class="flex space-x-2 items-center">Select All <input class="ml-3" type="checkbox" id="select-all"></th>
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
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#permissionsTable').DataTable({
                pageLength: 10, // Jumlah data per halaman
            });

            // Array untuk menyimpan permission ID yang dipilih
            var selectedPermissions = [];

            // Event listener untuk "Select All" checkbox
            $('#select-all').on('click', function() {
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);

                // Tambahkan atau hapus permission yang di-select dari halaman ini
                $('input[type="checkbox"]', rows).each(function() {
                    var permissionId = $(this).val();
                    if ($(this).prop('checked')) {
                        if (!selectedPermissions.includes(permissionId)) {
                            selectedPermissions.push(permissionId);
                        }
                    } else {
                        selectedPermissions = selectedPermissions.filter(id => id !== permissionId);
                    }
                });
            });

            // Event listener untuk checkbox per permission
            $('#permissionsTable tbody').on('change', 'input.permission-checkbox', function() {
                var permissionId = $(this).val();
                if ($(this).prop('checked')) {
                    if (!selectedPermissions.includes(permissionId)) {
                        selectedPermissions.push(permissionId);
                    }
                } else {
                    selectedPermissions = selectedPermissions.filter(id => id !== permissionId);
                }
            });

            // Saat form disubmit, tambahkan semua checkbox yang dipilih ke dalam form
            $('#permissionsForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah submit default
                // Kosongkan semua input yang sudah ada
                $(this).find('input[name="permissions[]"]').remove();

                // Tambahkan semua permission yang dipilih ke dalam form
                selectedPermissions.forEach(function(id) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'permissions[]',
                        value: id
                    }).appendTo('#permissionsForm');
                });

                // Kirim form dengan data yang sudah ditambahkan
                this.submit();
            });

            // Saat berpindah halaman, pastikan checkbox yang dipilih tetap tersimpan
            table.on('page', function() {
                var rows = table.rows({ 'search': 'applied' }).nodes();
                $('input.permission-checkbox', rows).each(function() {
                    var permissionId = $(this).val();
                    $(this).prop('checked', selectedPermissions.includes(permissionId));
                });
            });
        });
    </script>
</x-app-layout>
