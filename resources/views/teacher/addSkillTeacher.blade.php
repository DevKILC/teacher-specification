<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 flex-col justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top section -->
            <div class="flex items-center text-left w-full h-16 mt-2 mb-6 bg-white py-5 rounded-md shadow-md">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-16" height="24px" viewBox="0 -960 960 960"
                        width="24px" fill="#000000">
                        <path
                            d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                    </svg>
                </span>
                <h1 class="text-2xl">
                    Add Skill to Mr/Mrs {{ $teachers->name ?? '' }}
                </h1>
            </div>

            <div class="flex h-auto items-center w-full justify-between text-center mt-6 mb-6">
                <div class="flex items-center">
                    <span class="bg-white w-16 h-16 flex items-center text-center rounded-md shadow-md mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7" height="24px" viewBox="0 -960 960 960"
                            width="24px" fill="#5f6368">
                            <path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl text-left">Skills Data</h1>
                </div>
                <form action="{{ route('teacher-skill.show', isset($teachers) ? $teachers->id : 0) }}" method="GET">
                    <div class="w-auto px-3 py-3 h-auto flex gap-3 bg-white shadow-md rounded-md">
                        <input type="text" name="skill_name" value="" class="rounded-md"
                            placeholder="Search skill here...">
                        <button type="submit"
                            class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" height="24px"
                                viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                <path
                                    d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                            </svg>
                        </button>
                        <a href="{{ route('teacher-skill.show',isset($teachers) ? $teachers->id : 0) }}"
                            class="bg-red-600 text-white hover:bg-red-700 py-2 px-4 rounded-md text-center">
                            Reset
                        </a>
                    </div>
                </form>

            </div>


            <!-- skill List -->
            <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative flex-col justify-center"
                x-data="{ selectedType: '' }">

                <!-- Dropdown untuk memilih tipe skill -->
                <div class="w-auto h-auto ml-5 mb-10">
                    <select name="type" x-model="selectedType" class="border-none h-max focus:border-white text-x5">
                        <option value="" selected>Show All</option>
                        <option value="OFFLINE">Offline</option>
                        <option value="ONLINE">Online</option>
                    </select>
                </div>
                @if (request()->segment(2) === '0')
                <div class="flex justify-center">
                    <p>No teacher selected or cannot adding skill for dummy teacher , try choose teacher first!</p>
                </div>
                @else
                    <form action="{{ route('teacher-skill.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="teacher_id" value="{{ $teachers->id ?? '' }}">
                        <div class="w-full mx-3 flex justify-center">
                            @if ($allSkills->isEmpty())
                                <p>No skills available or found.</p>
                            @else
                                <div class="grid grid-cols-6 gap-4 w-[95%]">
                                    @foreach ($allSkills as $skill)
                                        <div class="flex items-center space-x-2 p-2"
                                            x-show="selectedType === '' || selectedType === '{{ $skill->type }}'">
                                            <input type="checkbox" id="skill_{{ $skill->id }}" name="skill_id[]"
                                                value="{{ $skill->id }}"
                                                @if (isset($teachersSkillsGetValidation) && in_array($skill->id, $teachersSkillsGetValidation->toArray())) disabled checked
                                        class="accent-gray-400 bg-gray-500 cursor-not-allowed" @endif>
                                            <label for="skill_{{ $skill->id }}"
                                                class="text-gray-700" @if (isset($teachersSkillsGetValidation) && in_array($skill->id, $teachersSkillsGetValidation->toArray())) 
                                                class=" text-gray-300 cursor-not-allowed" @endif>{{ $skill->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                        @endif
                        <div class="w-[95%] h-16 mt-10 flex items-center justify-end ">
                            <div class="flex space-x-5">
                                <a href="">
                                    <x-button type="reset" class="ml-4">{{ __('Unselect Skill') }}</x-button>
                                </a>
                                <x-button type="submit">{{ __('Save') }}</x-button>
                            </div>
                        </div>
                    </form>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
