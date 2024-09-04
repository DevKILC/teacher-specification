<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">

            <!-- Header Title -->
            <h2 class="font-medium  text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <!-- Content -->
                <div class="w-full h-[350px] flex flex-row flex-wrap">
                    <!-- Wrapper card -->
                    <div class="flex flex-col w-[30%] h-full gap-4 justify-center items-center">
                        <!-- Card count data -->
                        <div class="p-6 bg-blue-700 text-center text-white w-[200px] h-[150px] rounded-md shadow-md">
                            <h3 class="font-light text-xl">Teachers</h3>
                            <p class="text-3xl font-thin mt-4">192</p>
                        </div>
                        <div class="p-6 bg-yellow-400 text-center text-white w-[200px] h-[150px] rounded-md shadow-md">
                            <h3 class="font-light text-xl">Total Data</h3>
                            <p class="text-3xl font-thin mt-4">200</p>
                        </div>
                        <!-- end card -->
                    </div>
                    <div class="bg-white w-[70%] h-full items-center shadow-md text-black flex flex-col rounded-md">
                        <h2 class="text-[20px] font-light mt-3">Offline Spectification</h2>
                    </div>
                    <!-- end Wrapper -->
                </div>
                <!-- end content -->
                <!-- table content -->
                <div class="bg-white w-full h-auto pb-10 mt-9 flex flex-col shadow-md rounded-md">
                    <h2 class="text-[20px] font-light text-black text-left  ml-[5%] my-10"> Teachers Data </h2>
                    @if($teachers->isEmpty())
                    <p>No teachers available.</p>
                    @else
                    <table class="table-auto" id="teachers-table">
                        <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Address
                                </th>
                                <th>
                                    Number
                                </th>
                                <th>
                                    Certifications 1
                                </th>
                                <th>
                                    Certifications 2
                                </th>
                                <th>
                                    Certifications 3
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr>
                                <th class="border px-4 py-2">
                                    {{ $teacher->name  ?? 'N/A' }}
                                </th>
                                <td class="border px-4 py-2">
                                    {{ $teacher->address ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $teacher->phone  ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $teacher->certifications[0]->name  ?? 'No Certification'}}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $teacher->certifications[1]->name  ?? 'No Certification'}}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $teacher->certifications[2]->name  ?? 'No Certification'}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    <!-- end table content -->
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