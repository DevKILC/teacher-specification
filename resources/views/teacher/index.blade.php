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
                <div class="w-full lg:w-[40%] h-auto bg-white rounded-md shadow-md p-6">
                    <img src="{{ $teachers->img_url }}" alt="Teacher Picture" class="w-full h-[350px] bg-yellow-400 mx-auto rounded-md object-cover">
                </div>

                <div class="w-full lg:w-[60%] bg-white h-auto rounded-md shadow-md p-6">
                    <h1 class="text-2xl text-left">{{ $teachers->name ?? 'N/A' }}</h1>
                    <table class="w-full h-60 mx-auto mt-2 border-collapse">
                        <tbody>
                            <tr>
                                <td class="text-base font-bold sm:text-lg md:text-lg pr-5 lg:text-lg">{{ $teachers->address ?? 'Not Found' }}</td>
                            </tr>
                            <div class="mt-10">
                            <tr class="">
                                <td class="text-base sm:text-lg border-b-2 border-gray-400 pt-10 font-semibold">{{ $teachers->username ?? 'Not Found' }}</td>
                            </tr>
                            <tr>
                                <td class="text-base sm:text-lg border-b-2 border-gray-400  font-semibold">{{ $teachers->phone ?? 'Not Found' }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-base sm:text-lg font-semibold">{{ $teachers->email ?? 'Not Found' }}</td>
                            </tr>
                            </div>
                           
                        </tbody>
                    </table>
                </div>

                <!-- Skills container -->
                <div class="w-full lg:w-[60%] flex flex-col h-auto bg-white shadow-md rounded-md p-6" x-data="{ openAddSkillModal: false }">
                    <div class="flex flex-row justify-between items-center border-yellow-400 border-b-2 pb-2">
                        <h1 class="text-left font-thin text-xl lg:text-[30px]">Skills list</h1>
                        <button @click="openAddSkillModal = true" class="w-[150px] lg:w-[150px] h-[30px] lg:h-[40px] bg-yellow-400 hover:bg-yellow-500 rounded-md text-white text-sm">+ Add New Skill</button>

                        {{-- Add Skill Modal --}}
                        <x-general.modal :open="'openAddSkillModal'" :title="__('Add Skill')">
                            <x-general.form-section id="addSkillTeacher" :submit="route('teacher-skill.store', ['id' => $teachers->id ?? 'null'])">
                                <x-slot name="form">
                                    <div class="col-span-6 sm:col-span-4">
                                        @csrf
                                        <input type="hidden" name="teacher_id" value="{{ $teachers->id ?? 'null' }}">
                                        <!-- Form Add Skill -->
                                        <label for="skillSelect" class="block mb-2 text-sm">Choose Skill Name</label>
                                        <div class="space-y-3">
                                            @foreach($allSkills as $skill)
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="skill_{{ $skill->id }}" name="skill_id[]" value="{{ $skill->id }}" @if(isset($teachersSkillsGetValidation) && in_array($skill->id, $teachersSkillsGetValidation->toArray())) disabled checked style="background-color: gray;" @endif>
                                                <label for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <x-input-error for="name" class="mt-2" />
                                    </div>
                                </x-slot>
                                <x-slot name="actions">
                                    <x-button class="bg-blue-500 text-white hover:bg-blue-600">{{ __('Save') }}</x-button>
                                    <x-button type="button" class="ml-4" @click="openSkillModal = false">{{ __('Cancel') }}</x-button>
                                </x-slot>
                            </x-general.form-section>
                        </x-general.modal>
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
                            <td class="py-2 text-right">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="p-2 rounded hover:bg-gray-100 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-20">
                                        <a href="{{ route('skill.edit', $teacherSkill->id) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                                        <form action="{{ route('skill.destroy', $teacherSkill->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-100">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
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