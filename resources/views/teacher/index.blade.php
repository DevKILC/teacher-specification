<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Teacher List -->
                @if($teachers->isEmpty())
                    <p>No teachers available.</p>
                @else
                    <table class="table-auto" id="teachers-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $teacher->name }}</td>
                                    <td class="border px-4 py-2">{{ $teacher->email }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('teacher.show', $teacher->id) }}" class="text-blue-500">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Script -->
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#teachers-table').DataTable();
            });
        </script>
    @endpush
</x-app-layout>