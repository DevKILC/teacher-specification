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
                            <p class="text-3xl font-thin mt-4">{{ $allTeachers }}</p>
                        </div>
                        <div class="p-6 bg-yellow-400 text-center text-white w-[200px] h-[150px] rounded-md shadow-md">
                            <h3 class="font-light text-xl">Total Data</h3>
                            <p class="text-3xl font-thin mt-4">200</p>
                        </div>
                        <!-- end card -->
                    </div>
                    <div class="bg-white w-[70%] h-full items-center shadow-md text-black flex flex-col rounded-md">
                        <h2 class="text-[20px] font-light mt-3">Offline Spectification</h2>
                        <canvas class="" id="myChart"></canvas>
                    </div>
                    <!-- end Wrapper -->
                </div>
                <!-- end content -->
                <!-- table content -->
                <div class="bg-white w-full h-auto pb-10 mt-9 mx-auto flex flex-col shadow-md rounded-md">
                    <h2 class="text-[20px] font-light text-black text-left  ml-[5%] my-10"> Teachers Data </h2>
                    @if($teachers->isEmpty())
                    <p>No teachers available.</p>
                    @else
                    <div class="w-[90%] h-full mx-auto -z-100">
                    <table class="table-auto" id="teachers-table">
                        <thead>
                            <tr>
                            <th>
                                    No
                                </th>
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
                                    Certifications
                                </th>
                                <th>
                                    Certifications
                                </th>
                                <th>
                                    Certifications
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th >
                                    {{ $teacher->name  ?? 'N/A' }}
                                </th>
                                <td >
                                    {{ $teacher->address ?? 'N/A' }}
                                </td>
                                <td >
                                    {{ $teacher->phone  ?? 'N/A' }}
                                </td>
                                <td >
                                    {{ $teacher->certifications[0]->name  ?? 'No Certification'}}
                                </td>
                                <td >
                                    {{ $teacher->certifications[1]->name  ?? 'No Certification'}}
                                </td>
                                <td >
                                    {{ $teacher->certifications[2]->name  ?? 'No Certification'}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
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

            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                        labels: @json($labels), // Labels from controller
                        datasets: [{
                        label: 'Teachers Total',
                        data: @json($data), // Data from controller
                        backgroundColor: '#fcce00',
                        borderColor: '#ddd',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 20,
                            }
                        }
                    }
                }
            });
        </script>
        @endpush
</x-app-layout>