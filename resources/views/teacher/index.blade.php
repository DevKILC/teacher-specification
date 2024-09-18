<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 flex-col justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top section -->
            <div class="w-[96%] h-auto flex items-center lg:flex-row lg:justify-between bg-white rounded-md shadow-md flex-col mx-[22px]">
                <div class="flex items-center">
                    <span class="mr-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-10" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                            <path d="M480-240q-56 0-107 17.5T280-170v10h400v-10q-42-35-93-52.5T480-240Zm0-80q69 0 129 21t111 59v-560H240v560q51-38 111-59t129-21Zm0-160q-25 0-42.5-17.5T420-540q0-25 17.5-42.5T480-600q25 0 42.5 17.5T540-540q0 25-17.5 42.5T480-480ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h480q33 0 56.5 23.5T800-800v640q0 33-23.5 56.5T720-80H240Zm240-320q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Zm0-140Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl text-left">Teacher Biodata</h1>
                </div>
                <!-- Form section -->
                <div class="w-auto h-auto py-3 mr-4 flex gap-x-5 items-center">
                    <form id="searchTeacher" action="{{ route('teacher.index') }}" method="GET" class="flex items-center">
                        <select class="select-teacher w-48 pb-4 border-gray-300 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" name="id">
                            <option value="">Choose Teacher</option>
                            @foreach($allTeachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ request('id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="ml-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Profile section -->
            <div class="overflow-hidden w-full sm:rounded-lg p-6 flex flex-col lg:flex-row gap-5">
                <!-- Teacher profile -->
                <div class="w-full lg:w-[60%] h-auto">
                    <!-- Photo -->
                    <div class="w-full flex items-center bg-white h-auto rounded-md shadow-md p-6">
                        <img src="{{ $teachers->img_url }}" alt="Teacher Picture" class="w-[150px] h-[150px] bg-yellow-400 border-yellow-400 border-2 rounded-full object-cover">
                        <div class="ml-6">
                            <!-- name & addres -->
                            <h1 class="text-2xl text-left">{{ $teachers->name ?? 'N/A' }}</h1>
                            <p class="mt-2 text-sm"> {{ $teachers->email ?? 'Not Found'  }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-start bg-white h-auto rounded-md shadow-md mt-2 p-6 gap-4">
                        <div class="flex w-full items-center border-yellow-400 border-b-2 pb-2">
                            <h1 class="text-left text-xl ">Biodata</h1>
                        </div>
                        @role('Administrator')
                        <div class="flex flex-col">
                            <label for="username" class="font-semibold">Username</label>
                            <p id="username" class="text-gray-700"> {{ $teachers->username ?? 'Not Found' }} </p>
                        </div>

                        <div class="flex flex-col">
                            <label for="phone" class="font-semibold">Phone</label>
                            <p id="phone" class="text-gray-700"> {{ $teachers->phone ?? 'Not Found' }} </p>
                        </div>

                        <div class="flex flex-col">
                            <label for="address" class="font-semibold">Address</label>
                            <p id="address" class="text-gray-700"> {{ $teachers->address ?? 'Not Found' }} </p>
                        </div>
                        @endrole
                        @role('Teacher')
                        <div class="flex w-full justify-center items-center h-full">
                            <p id="phone" class="text-gray-700"> You Do not have any permission for this information </p>
                        </div>
                        @endrole
                        @unlessrole('Administrator|Teacher')
                        <div class="flex w-full justify-center items-center h-full">
                            <p class="text-gray-700"> You do not have any permission for this information </p>
                        </div>
                        @endunlessrole
                    </div>

                </div>

                <!-- Skills container -->
                <div class="w-full lg:w-[60%] flex flex-col h-auto bg-white shadow-md rounded-md p-6">
                    <div class="flex flex-row justify-between items-center border-yellow-400 border-b-2 pb-2">
                        <h1 class="text-left font-thin text-xl lg:text-[30px]">Skills list</h1>
                        @can('Add teacher skills')
                        <a href="{{ route('teacher-skill.show', $teachers->id ) }}">
                            <button class="w-[150px] lg:w-[150px] h-[30px] lg:h-[40px] bg-yellow-400 hover:bg-yellow-500 rounded-md text-white text-sm">
                                + Add New Skill
                            </button>
                        </a>
                        @elsecan('Administrator')
                        <!-- Jika user adalah Administrator tetapi tidak punya permission -->
                        <a href="{{ route('teacher-skill.show', $teachers->id ) }}">
                            <button class="w-[150px] lg:w-[150px] h-[30px] lg:h-[40px] bg-yellow-400 hover:bg-yellow-500 rounded-md text-white text-sm">
                                + Add New Skill
                            </button>
                        </a>
                        @endcan
                    </div>

                    <!-- Skills table -->
                    <table class="w-full mt-4 border-collapse">
                        @if(!$teachers)
                        <tr>
                            <td colspan="3" class="text-center text-gray-500">No teachers available.</td>
                        </tr>
                        @else
                        @forelse($teachers->teacherSkills as $index => $teacherSkill)
                        <tr class="border-b border-gray-300">
                            <td class="py-2 text-gray-800 font-medium">{{ $index + 1 }}</td>
                            <td class="py-2 text-gray-700">{{ $teacherSkill->skills->name ?? 'No skills available' }}</td>
                            @role('Administrator')
                            <td class="py-2 text-right">
                                <div class="relative">
                                    <form action="{{ route('skill.destroy', $teacherSkill->id) }}" id="deleteSkillFormTeacher" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button id="removeSkillButton" class="p-2 rounded hover:bg-gray-100 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                                                <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                </div>
                </td>
                @endrole
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500">No skills available.</td>
                </tr>
                @endforelse
                @endif
                </table>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loading saat menambahkan skill ke teacher
            $(".select-teacher").select2({

            });
            const addSkillForm = document.getElementById('addSkillTeacher');
            if (addSkillForm) {
                addSkillForm.addEventListener('submit', function() {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we adding the skill',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                });
            }
            // Konfirmasi dan loading saat menghapus skill dari teacher
            document.getElementById('removeSkillButton').addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah form di-submit secara otomatis
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Are you sure you want to remove this skill from this teacher?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we delete the skill',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        document.getElementById('deleteSkillFormTeacher').submit(); // Submit form setelah konfirmasi SweetAlert
                    }
                });
            });
        });
    </script>
</x-app-layout>