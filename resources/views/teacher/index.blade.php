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
                        alt="Teacher Picture" class="w-full h-[350px] bg-yellow-400 mx-auto rounded-md">
                    @else
                    <img src="{{ asset('img/lclogonobg.png') }}" alt="Default Picture"
                        class="w-full h-[350px] bg-yellow-400 mx-auto rounded-md">
                    <p class="text-center text-gray-500 mt-2">This Teacher Doesn't Have Any Picture</p>
                    @endif

                    <!-- Data -->
                    <ul class="w-full h-auto mx-auto mt-10 space-y-4 list-none">
                        <li class="text-2xl md:text-3xl font-thin border-b-2 border-yellow-400 pb-2">
                            <span class="inline-block w-28">Name</span>
                            <span class="inline-block">:<span class="ml-4">Test</span></span>
                        </li>
                        <li class="pl-5">
                            <span class="inline-block w-28">ID</span>
                            <span class="inline-block">:<span
                                    class="ml-4 text-gray-500 text-justify font-light">Test</span></span>
                        </li>
                        <li class="pl-5">
                            <span class="inline-block w-28">Username</span>
                            <span class="inline-block">:<span
                                    class="ml-4 text-gray-500 text-justify font-light">Test</span></span>
                        </li>
                        <li class="pl-5">
                            <span class="inline-block w-28">Email</span>
                            <span class="inline-block">:<span
                                    class="ml-4 text-gray-500 text-justify font-light">Test</span></span>
                        </li>
                        <li class="pl-5">
                            <span class="inline-block w-28">Address</span>
                            <span class="inline-block">:<span
                                    class="ml-4 text-gray-500 text-justify font-light">Test</span></span>
                        </li>
                        <li class="pl-5">
                            <span class="inline-block w-28">Phone</span>
                            <span class="inline-block">:<span
                                    class="ml-4 text-gray-500 text-justify font-light">Test</span></span>
                        </li>
                    </ul>

                </div>
                <!-- End profile -->

                <!-- Skills container -->
                <div class="w-full lg:w-[60%] flex flex-col h-auto bg-white shadow-md rounded-md p-6">
                    <!-- Header skill -->
                    <div class="flex flex-row justify-between items-center border-yellow-400 border-b-2 pb-2">
                        <h1 class="text-left font-thin text-xl lg:text-[30px]">Skills list</h1>

                        <!-- Trigger Button for Modal -->
                        <button @click="open = true"
                            class="w-[150px] lg:w-[180px] h-[40px] lg:h-[50px] bg-yellow-400 hover:bg-yellow-500 rounded-md text-white">+
                            Add New Skill</button>

                    </div>

                    <!-- Modal Component -->
                    <x-modal id="myModal" maxWidth="2xl">

                        <div class="modal-header flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">Add Skill</h2>
                            <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ route('teacherskills.store', ['id' => $teacher->id]) }}" method="POST">
                                @csrf
                                <!-- Hidden teacher ID -->
                                <input type="hidden" name="teacher_id" value="{{ $teachers->id ?? null }}">

                                <!-- Skill Selection -->
                                <label for="skillSelect" class="block mb-2 text-sm">Choose Skill Name</label>
                                <div class="space-y-3">
                                    @foreach($allSkills as $skill)
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="skill_{{ $skill->id_skill }}" name="skill_id[]"
                                            value="{{ $skill->id_skill }}" @if(isset($teachersSkillsGetValidation) &&
                                            in_array($skill->id_skill, $teachersSkillsGetValidation->toArray()))
                                        disabled checked class="bg-gray-500"
                                        @endif>
                                        <label for="skill_{{ $skill->id_skill }}">{{ $skill->name_skill }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Buttons -->
                                <div class="mt-5 flex justify-end space-x-3">
                                    <button type="button" @click="open = false"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-md">Close</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Confirm
                                        Skill</button>
                                </div>
                            </form>

                        </div>
                    </x-modal>

                    <!-- Skills list (Empty table for now) -->
                    <table class="mt-4">
                        <!-- Skill items go here -->
                    </table>
                    <!-- End skills -->
                </div>
                <!-- End skills container -->
            </div>
            <!-- End container profile -->
        </div>
    </div>
</x-app-layout>