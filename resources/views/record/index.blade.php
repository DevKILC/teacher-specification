<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Records') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  flex flex-col">

            <div class="w-full flex lg:flex-row lg:float-right gap-x-5 my-5" x-data="{ openAddTeacherActivity : false , OpenAddActivityCategory : false }">
                <!-- Button & Modal Add Teacher Activities  -->
                 <button @click="openAddTeacherActivity = true" class="bg-yellow-400 text-white hover:bg-yellow-500 py-2 px-4 rounded-md w-30 h-10">
                    Add Teacher Activity
                </button>
                <x-general.modal :open="'openAddTeacherActivity'" :title="__('Set Teacher Activity')">
                            <x-general.form-section id="addSkillTeacher" :submit="route('teacher-skill.store', ['id' => $teachers->id ?? 'null' ])">
                                <x-slot name="form">
                                    <div class="col-span-6 sm:col-span-4">
                                        @csrf
                                          
                                        <!-- Form Add SKill -->
                                        <!-- <label for="skillSelect" class="block mb-2 text-sm">Choose Skill Name</label>
                                        <div class="space-y-3">
                                            @foreach($allSkills as $skill)
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="skill_{{ $skill->id }}" name="skill_id[]"
                                                    value="{{ $skill->id }}" @if(isset($teachersSkillsGetValidation) &&
                                                    in_array($skill->id, $teachersSkillsGetValidation->toArray() ))
                                                disabled checked style="background-color: gray;" @endif>
                                                <label for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
                                            </div>
                                            @endforeach
                                        </div> -->
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

                <!-- Button & Modal Add Activities Category -->
                 <button @click="OpenAddActivityCategory = true" class="bg-yellow-400 text-white hover:bg-yellow-500 py-2 px-4 rounded-md w-30 h-10">
                    Add Activity Category
                </button>
            </div>
            <div class="w-full bg-white shadow-md rounded-md h-auto pb-30">
                <div class="flex flex-col justify-center lg:flex-row lg:justify-between item-center px-5 py-5">
                    <!-- Header Title -->
                    <h1 class="text-xl font-light">Records Activity</h1>
                    <!-- Date range -->
                    <div class="flex flex-row w-[40%] items-center gap-x-2">
                        <!-- Date From -->
                        <input type="date" class="border-2 border-gray-300 rounded-md px-4 py-2 w-full" />
                        <!-- Date To -->
                        <input type="date" class="border-2 border-gray-300 rounded-md px-4 py-2 w-full" />
                        <!-- Filter Button -->
                        <button class="bg-yellow-400 text-white hover:bg-yellow-500 py-2 px-4 rounded-md">
                            Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>