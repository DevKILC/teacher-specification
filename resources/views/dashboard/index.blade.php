<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">
            <!-- Header Title -->
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <!-- Content -->
                <!-- Wrapper card -->
                <div class="flex items-center text-left w-full h-16 my-12 bg-white py-5 rounded-md shadow-md">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                            <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl">
                        Data Preview
                    </h1>
                </div>
                <div class="flex flex-wrap gap-x-[26px] gap-y-10 bg-gray-100 px-4">
                    <!-- card 1 total data count -->
                    <div class="flex w-[210px] h-32">
                        <div class="flex w-full max-w-full flex-col break-words rounded-lg border border-gray-100 bg-white text-gray-600 shadow-lg">
                            <div class="p-3">
                                <div class="absolute -mt-10 h-12 w-12 rounded-xl bg-gradient-to-tr from-yellow-500 to-yellow-200 text-center text-white shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-2 -ml-2 h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                        <path d="M480-120q-151 0-255.5-46.5T120-280v-400q0-66 105.5-113T480-840q149 0 254.5 47T840-680v400q0 67-104.5 113.5T480-120Zm0-479q89 0 179-25.5T760-679q-11-29-100.5-55T480-760q-91 0-178.5 25.5T200-679q14 30 101.5 55T480-599Zm0 199q42 0 81-4t74.5-11.5q35.5-7.5 67-18.5t57.5-25v-120q-26 14-57.5 25t-67 18.5Q600-528 561-524t-81 4q-42 0-82-4t-75.5-11.5Q287-543 256-554t-56-25v120q25 14 56 25t66.5 18.5Q358-408 398-404t82 4Zm0 200q46 0 93.5-7t87.5-18.5q40-11.5 67-26t32-29.5v-98q-26 14-57.5 25t-67 18.5Q600-328 561-324t-81 4q-42 0-82-4t-75.5-11.5Q287-343 256-354t-56-25v99q5 15 31.5 29t66.5 25.5q40 11.5 88 18.5t94 7Z" />
                                    </svg>

                                </div>
                                <div class="pt-1 text-right">
                                    <p class="text-xl font-bold capitalize">Data Total</p>
                                </div>
                            </div>
                            <hr class="opacity-50" />
                            <div class="p-4">
                                <p class="font-light -p-5  text-center"><span class="text-3xl font-bold text-green-600">{{ $totalCount }} </span>Data</p>
                            </div>
                        </div>
                    </div>
                    <!-- card 2 teachers count -->
                    <div class="flex w-[210px] h-32">
                        <div class="flex w-full max-w-full flex-col break-words rounded-lg border border-gray-100 bg-white text-gray-600 shadow-lg">
                            <div class="p-3">
                                <div class="absolute -mt-10 h-12 w-12 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 text-center text-white shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-2 -ml-2 h-7 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="pt-1 text-right">
                                    <p class="text-xl font-bold capitalize">Teachers</p>
                                </div>
                            </div>
                            <hr class="opacity-50" />
                            <div class="p-4">
                                <p class="font-light -p-5 text-center"><span class="text-3xl font-bold text-green-600">{{ $teachersCount }} </span>Person</p>
                            </div>
                        </div>
                    </div>
                    <!-- card 3 Skill count -->
                    <div class="flex w-[210px] h-32">
                        <div class="flex w-full max-w-full flex-col break-words rounded-lg border border-gray-100 bg-white text-gray-600 shadow-lg">
                            <div class="p-3">
                                <div class="absolute -mt-10 h-12 w-12 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 text-center text-white shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-2 -ml-2 h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                        <path d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z" />
                                    </svg>
                                </div>
                                <div class="pt-1 text-right">
                                    <p class="text-xl font-bold capitalize">Skills</p>
                                </div>
                            </div>
                            <hr class="opacity-50" />
                            <div class="p-4">
                                <p class="font-light -p-5  text-center"><span class="text-3xl font-bold text-green-600">{{ $skillCount }} </span>Skills</p>
                            </div>
                        </div>
                    </div>
                    <!-- card 4 category count -->
                    <div class="flex w-[210px] h-32">
                        <div class="flex w-full max-w-full flex-col break-words rounded-lg border border-gray-100 bg-white text-gray-600 shadow-lg">
                            <div class="p-3">
                                <div class="absolute -mt-10 h-12 w-12 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 text-center text-white shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-2 -ml-2 h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                        <path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z" />
                                    </svg>
                                </div>
                                <div class="pt-1 text-right">
                                    <p class="text-xl font-bold capitalize">Category</p>
                                </div>
                            </div>
                            <hr class="opacity-50" />
                            <div class="p-4">
                                <p class="font-light -p-5  text-center"><span class="text-3xl font-bold text-green-600">{{ $categoryCount }} </span>Categories</p>
                            </div>
                        </div>
                    </div>
                    <!--card 5 activity count -->
                    <div class="flex w-[210px] h-32">
                        <div class="flex w-full max-w-full flex-col break-words rounded-lg border border-gray-100 bg-white text-gray-600 shadow-lg">
                            <div class="p-3">
                                <div class="absolute -mt-10 h-12 w-12 rounded-xl bg-gradient-to-tr from-blue-700 to-blue-500 text-center text-white shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-2 -ml-2 h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                        <path d="m216-160-56-56 384-384H440v80h-80v-160h233q16 0 31 6t26 17l120 119q27 27 66 42t84 16v80q-62 0-112.5-19T718-476l-40-42-88 88 90 90-262 151-40-69 172-99-68-68-266 265Zm-96-280v-80h200v80H120ZM40-560v-80h200v80H40Zm739-80q-33 0-57-23.5T698-720q0-33 24-56.5t57-23.5q33 0 57 23.5t24 56.5q0 33-24 56.5T779-640Zm-659-40v-80h200v80H120Z" />
                                    </svg>
                                </div>
                                <div class="pt-1 text-right">
                                    <p class="text-xl font-bold capitalize">Activity</p>
                                </div>
                            </div>
                            <hr class="opacity-50" />
                            <div class="p-4">
                                <p class="font-light -p-5  text-center"><span class="text-3xl font-bold text-green-600">{{ $activityCount }} </span>Activities</p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- bar chart -->
                 <div class="flex h-auto items-center text-center mt-12 mb-6">
                    <span class="bg-white w-16 h-16 flex items-center text-center rounded-md shadow-md mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z"/></svg>
                    </span>
                    <h1 class="text-2xl text-left">Online & Offline Specification Chart</h1>
                 </div>
                <!-- Chart content -->
                <div class="flex flex-col lg:flex-row gap-y-4 gap-x-4 w-full h-auto">
                    <div class="bg-white lg:col-span-2 w-full h-full mt-8 shadow-lg text-black flex flex-col rounded-lg">
                        <h2 class="text-[22px] font-light mt-4 ml-4">Online Specification</h2>
                        <canvas id="onlineChart" class="w-full h-full p-4"></canvas>
                    </div>
                    <div class="bg-white lg:col-span-2 w-full h-full mt-8 shadow-lg text-black flex flex-col rounded-lg">
                        <h2 class="text-[22px] font-light mt-4 ml-4">Offline Specification</h2>
                        <canvas id="offlineChart" class="w-full h-full p-4"></canvas>
                    </div>
                </div>
                <div class="flex h-auto items-center text-center my-12">
                    <span class="bg-white w-16 h-16 flex items-center text-center rounded-md shadow-md mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7"  height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M360-120q-33 0-56.5-23.5T280-200v-400q0-33 23.5-56.5T360-680h400q33 0 56.5 23.5T840-600v400q0 33-23.5 56.5T760-120H360Zm0-400h400v-80H360v80Zm160 160h80v-80h-80v80Zm0 160h80v-80h-80v80ZM360-360h80v-80h-80v80Zm320 0h80v-80h-80v80ZM360-200h80v-80h-80v80Zm320 0h80v-80h-80v80Zm-480-80q-33 0-56.5-23.5T120-360v-400q0-33 23.5-56.5T200-840h400q33 0 56.5 23.5T680-760v40h-80v-40H200v400h40v80h-40Z"/></svg>
                     </span>
                    <h1 class="text-2xl text-left">Teachers Data Tables</h1>
                 </div>
                <!-- Table content -->
                <div class="bg-white w-full h-auto py-10 mx-auto flex flex-col shadow-lg rounded-lg">
                    @if($teachers->isEmpty())
                    <p class="text-center">No teachers available.</p>
                    @else
                    <div class="w-[90%] h-full mx-auto">
                        <table class="table-auto w-full py-10" id="teachers-table">
                            <thead class="">
                                <tr>
                                    <th class="px-4 py-2">No</th>
                                    <th class="px-4 py-2">Name</th>
                                    <th class="px-4 py-2">Username</th>
                                    @if(userHasAction('dashboard:detail-teacher'))
                                    <th class="px-4 py-2">Address</th>
                                    <th class="px-4 py-2">Number</th>
                                    @endif
                                    <th class="px-4 py-2">Certification 1</th>
                                    <th class="px-4 py-2">Certification 2</th>
                                    <th class="px-4 py-2">Certification 3</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach($teachers as $teacher)
                                <tr class="bg-white hover:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $teacher->name ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $teacher->username ?? 'N/A' }}</td>
                                    @if(userHasAction('dashboard:detail-teacher'))
                                    <td class="border px-4 py-2">{{ $teacher->address ?? 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ $teacher->phone ?? 'N/A' }}</td>
                                    @endif
                                    <td class="border px-4 py-2">{{ $teacher->certifications[0]->name ?? 'No Certification' }}</td>
                                    <td class="border px-4 py-2">{{ $teacher->certifications[1]->name ?? 'No Certification' }}</td>
                                    <td class="border px-4 py-2">{{ $teacher->certifications[2]->name ?? 'No Certification' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <!-- End table content -->
            </div>
        </div>
    </div>

    <!-- Script -->
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#teachers-table').DataTable();
        });

        var ctxOffline = document.getElementById('offlineChart').getContext('2d');
        var offlineChart = new Chart(ctxOffline, {
            type: 'bar',
            data: {
                labels: @json($labels), // Labels dari controller
                datasets: [{
                    label: 'Teacher with Offline Skills',
                    data: @json($dataOffline), // Data skill offline dari controller
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart untuk Online Skills
        var ctxOnline = document.getElementById('onlineChart').getContext('2d');
        var onlineChart = new Chart(ctxOnline, {
            type: 'bar',
            data: {
                labels: @json($labels), // Labels dari controller
                datasets: [{
                    label: 'Teacher with Online Skills',
                    data: @json($dataOnline), // Data skill online dari controller
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>