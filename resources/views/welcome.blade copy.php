<x-guest-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">


                <div class= "bg-white w-full h-52 py-10 mx-auto flex flex-col shadow-lg rounded-lg">

                    <div class="text-black bg-white w-full h-auto py-10 mx-auto flex flex-col shadow-lg rounded-lg">

                        <form>
                            <div class="flex flex-warp flex-row gap-3">
                                <select class="w-52"
                                    style="border-radius:5px ;  border-style: solid;
                            border-color: gray;"
                                    id="skillCategory" id="skillCategory" name="category_name" x-model="skill.category_id"
                                    required>
                                    <option value="">{{ __('Categories') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $teacher_category_skill_count[$category->id] }})
                                        </option>
                                    @endforeach
                                </select>
                                <select class="w-52"
                                    style="border-radius:5px ;  border-style: solid;
                        border-color: gray;"
                                    id="skill" id="skill" name="skill_name"
                                    x-model="skill.skill_id" required>
                                    <option value="">{{ __('Skills') }}</option>
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}"
                                            {{ old('skill_id') == $skill->id ? 'selected' : '' }}>
                                            {{ $skill->name }} ({{ $teacher_skill_count[$skill->id] }})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded-md flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" height="24px"
                                        viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                                        <path
                                            d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                                    </svg>
                                </button>
                                <a href=""
                                    class="bg-red-600 text-white hover:bg-red-700 py-2 px-4 rounded-md text-center">
                                    Reset
                                </a>
                        </form>
                    </div>



                </div>

            </div>


        </div>
    </div>
    </div>
</x-guest-layout>
