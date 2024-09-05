<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top section (optional placeholder) -->
            <div class="w-full h-10 bg-white rounded-md shadow-md">

                <form action="{{ route('teacher.index') }}" method="GET">
                    <select name="id" onchange="this.form.submit()" class="w-full h-full">
                        <option value="">Choose Teacher</option>
                        @foreach($allTeachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                        @endforeach
                    </select>
                </form>

            </div>

            <!-- Container profile -->
            <div class="overflow-hidden sm:rounded-lg p-6 flex flex-col lg:flex-row gap-5">

                <!-- Teacher profile -->
                <div class="flex flex-col bg-white w-full lg:w-[40%] h-auto rounded-md shadow-md p-6">
                    <!-- Picture -->
                    <!-- Picture -->
                    @if($teachers && $teachers->img_url)
                    <img src="{{ str_contains($teachers->img_url, 'http') ? $teachers->img_url : 'https://s3.ap-southeast-1.wasabisys.com/file-members.kampunginggris.id/' . $teachers->img_url }}"
                        alt="Teacher Picture" class="w-full h-[350px] bg-yellow-400 mx-auto rounded-md object-cover">

                    @else
                    <p class="text-center text-white items-center w-full h-[350px] bg-yellow-400 mx-auto rounded-md">This Teacher Doesn't Have Any Picture</p>
                    @endif

                    <!-- Data -->
                    <!-- Data Table -->
                    <table class="w-full h-[300px] mx-auto mt-10 border-collapse border-b-2 border-yellow-400">
                        <tbody>
                            <tr class="border-b-2 border-yellow-400 pb-2 font-thin">
                                <td class="w-28 text-lg sm:text-xl md:text-2xl lg:text-3xl">Name</td>
                                <td class="text-base sm:text-lg md:text-xl lg:text-2xl">: <span
                                        class="ml-4">{{ $teachers->name  ?? 'Select Teacher first' }}</span></td>
                            </tr>
                            <tr class="pl-5">
                                <td class="w-28 text-lg sm:text-xl font-light">ID</td>
                                <td class="text-base sm:text-lg font-light">: <span
                                        class="ml-4 text-gray-500">{{ $teachers->id ?? 'N/A' }}</span></td>
                            </tr>
                            <tr class="pl-5">
                                <td class="w-28 text-lg sm:text-xl font-light">Username</td>
                                <td class="text-base sm:text-lg font-light">: <span
                                        class="ml-4 text-gray-500">{{ $teachers->username ?? 'Not Found' }}</span></td>
                            </tr>
                            <tr class="pl-5 overflow-x ">
                                <td class="w-28 text-lg sm:text-xl font-light">Email</td>
                                <td class="text-base sm:text-lg font-light">: <span
                                        class="ml-4 text-gray-500">{{ $teachers->email  ?? 'Not Found' }}</span></td>
                            </tr>
                            <tr class="pl-5">
                                <td class="w-28 text-lg sm:text-xl font-light">Address</td>
                                <td class="text-base sm:text-lg font-light">: <span
                                        class="ml-4 text-gray-500">{{ $teachers->address  ?? 'Not Found' }}</span></td>
                            </tr>
                            <tr class="pl-5">
                                <td class="w-28 text-lg sm:text-xl font-light">Phone</td>
                                <td class="text-base sm:text-lg font-light">: <span
                                        class="ml-4 text-gray-500">{{ $teachers->phone  ?? 'Not Found' }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- End Data Table -->


                </div>
                <!-- End profile -->

                <!-- Skills container -->
                <div class="w-full lg:w-[60%] flex flex-col h-auto bg-white shadow-md rounded-md p-6"  x-data="{ openAddSkillModal: false }">
                    <!-- Header skill -->
                    <div class="flex flex-row justify-between items-center border-yellow-400 border-b-2 pb-2"
                       >
                        <h1 class="text-left font-thin text-xl lg:text-[30px]">Skills list</h1>

                        <!-- Trigger Button for Modal -->
                        <button @click="openAddSkillModal = true"
                            class="w-[150px] lg:w-[150px] h-[30px] lg:h-[40px] bg-yellow-400 hover:bg-yellow-500 rounded-md text-white text-sm">
                            + Add New Skill
                        </button>


                        {{-- Add Skill Modal  --}}
                        <x-general.modal :open="'openAddSkillModal'" :title="__('Add Skill')">
                            <x-general.form-section :submit="route('addskill.store', ['id' => $teachers->id ?? 'null' ])">
                            <x-slot name="form">
                                <div class="col-span-6 sm:col-span-4">
                                    @csrf
                                    <input type="hidden" name="teacher_id" value="{{ $request->id ?? 'null' }}">
                                    <!-- Form Add SKill -->
                                    <label for="skillSelect" class="block mb-2 text-sm">Choose Skill Name</label>
                                    <div class="space-y-3">
                                        @foreach($allSkills as $skill)
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" id="skill_{{ $skill->id_skill }}" name="id_skill[]"
                                                value="{{ $skill->id_skill }}" @if(in_array($skill->id_skill,
                                            $teachersSkillsGetValidation)) disabled checked @endif>
                                            <label for="skill_{{ $skill->id_skill }}">{{ $skill->name }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <x-input-error for="name" class="mt-2" />
                                </div>
                            </x-slot>
                                <!-- Actions slot (optional) -->
                                <x-slot name="actions">
                                    <x-button class="bg-blue-500 text-white hover:bg-blue-600">
                                        {{ __('Save') }}
                                    </x-button>
                                    <x-button type="button" class="ml-4" @click="openSkillModal = false">
                                        {{ __('Cancel') }}
                                    </x-button>
                                </x-slot>
                            </x-general.form-section>
                        </x-general.modal>

                    </div>
                    <!-- Skills list (Empty table for now) -->
                    <!-- Skill Table -->
                    <table class="w-full mt-4 border-collapse">
                        @if(!$teachers)
                        <tr>
                            <td colspan="3" class="text-center text-gray-500">No teachers available.</td>
                        </tr>
                        @else
                        @forelse($teachers->teacherSkills as $index => $teacherSkill)
                        <tr class="border-b border-gray-300">
                            <td class="py-2 text-gray-800 font-medium">{{ $index + 1 }}</td>
                            <td class="py-2 text-gray-700">{{ $teacherSkill->skills->name ?? 'No skills available' }}
                            </td>
                            <td class="py-2 text-right">
                                <div x-data="{ open: false }" class="relative">
                                    <!-- Dropdown Button -->
                                    <button @click="open = !open"
                                        class="p-2 rounded hover:bg-gray-100 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#5f6368">
                                            <path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown Content -->
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-40 bg-white border border-gray-300 rounded-md shadow-lg z-10">
                                        <form action="{{ route('delete-teacher-skill') }}" method="POST" class="p-2">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id_teacher" value="{{ $teachers->id }}">
                                            <input type="hidden" name="id_skill"
                                                value="{{ $teacherSkill->skills->id_skill }}">
                                            <button type="submit"
                                                class="w-full text-left text-red-600 hover:bg-red-100 py-1 px-3 rounded-md"
                                                onclick="return confirm('Are you sure you want to remove this skill from {{ $teachers->name }}?')">
                                                Remove
                                            </button>
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

                    <!-- End skills -->
                </div>
                <!-- End skills container -->
            </div>
            <!-- End container profile -->
        </div>
    </div>
</x-app-layout>