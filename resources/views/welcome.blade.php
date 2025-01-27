<x-guest-layout>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="overflow-hidden sm:rounded-lg">

                

                <div class= " w-full h-auto py-10 mx-auto flex flex-col ">

                    <div class="text-black py-2.5 bg-white w-[85%] h-12 items-center mx-auto flex shadow-lg rounded-lg border">

                        <div class="flex justify-center items-center w-full">
                            <a><img src="{{ asset('img/lclogonobg.png') }}" class="w-[100px] h-[40px]" alt=""></a>

                            {{-- <ul class="flex flex-row gap-4">

                                <li><a href="#home">Home</a></li>
                                <li><a href="#table">Table</a></li>
                                <li><a href="#graphic">Graphic</a></li>
                                <li><a href=""></a></li>
                                <li><a href=""></a></li>

                            </ul> --}}

                        </div>

                    </div>

                    {{-- Headline --}}
                    
                    <div class="flex flex-col mt-10 h-auto w-full justify-center align-center items-center">

                        <h1 class="text-[50px] text-center text-black font-extrabold">Teacher Data Specification</h1>
                        <h1 class="text-[50px] text-center text-black font-extrabold">Teacher Data Skill Management System</h1>
                        <p class="text-center text-gray-700 text-lg mt-4">
                            The Teacher Data Management System simplifies the organization and retrieval of essential teacher information for streamlined educational administration.
                        </p>
                        <div class="flex justify-center align-center items-center">
                        <a href="{{ route('login') }}" class="w-max bg-black mt-5 py-2 px-3 text-white rounded-md shadow-sm ">Login To Dashboard</a>
                    </div>                                             
                    </div>

                </div>
                
                <section id="home" class=" w-full h-screen flex flex-col items-center p-5">
                 
                    <form action="{{ route('index')  }}" method="GET">
                        @csrf
                        <div class="flex flex-warp flex-row gap-3">
                            <div class="bg-white shadow-md rounded-md w-max flex flex-row justify-between items-center h-auto px-4 py-2 border">
                                <svg xmlns="http://www.w3.org/2000/svg" class=" h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="black">
                                    <path d="m260-520 220-360 220 360H260ZM700-80q-75 0-127.5-52.5T520-260q0-75 52.5-127.5T700-440q75 0 127.5 52.5T880-260q0 75-52.5 127.5T700-80Zm-580-20v-320h320v320H120Zm580-60q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm-500-20h160v-160H200v160Zm202-420h156l-78-126-78 126Zm78 0ZM360-340Zm340 80Z" />
                                </svg>
            
                                <select class="w-32 text-sm h-10 rounded-sm shadow-sm border-none"
                                id="skillCategory" name="category_name" x-model="skill.category_id"
                                required  onchange="this.form.submit()">
                                <option value="">{{ __('Categories') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}"
                                        {{ old('category_id') == $category['id'] ? 'selected' : '' }}>
                                        {{ $category['name'] }} ({{ $category['total_teacher'] }})
                                    </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="bg-white shadow-md rounded-md w-max flex flex-row justify-between items-center h-auto px-4 py-2 border">
                                <svg xmlns="http://www.w3.org/2000/svg" class=" h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="black">
                                    <path d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z" />
                                </svg>
            
                                <select class="w-32 text-sm h-10 rounded-sm shadow-sm border-none"
                                id="skill" name="skill_name"
                                x-model="skill.skill_id" required
                                onchange="this.form.submit()">
                                <option value="">{{ __('Skills') }}</option>
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->id }}"
                                        {{ old('skill_id') == $skill->id ? 'selected' : '' }}>
                                        {{ $skill->name }} ({{ $teacher_skill_count[$skill->id] ?? 0}})
                                    </option>
                                @endforeach
                            </select>
                            </div>
                            <a href="{{ route('index') }}"
                                class="flex rounded-md items-end"><svg xmlns="http://www.w3.org/2000/svg" alt="Reset" class="" height="24px" viewBox="0 -960 960 960" width="24px" fill="black"><path d="M440-122q-121-15-200.5-105.5T160-440q0-66 26-126.5T260-672l57 57q-38 34-57.5 79T240-440q0 88 56 155.5T440-202v80Zm80 0v-80q87-16 143.5-83T720-440q0-100-70-170t-170-70h-3l44 44-56 56-140-140 140-140 56 56-44 44h3q134 0 227 93t93 227q0 121-79.5 211.5T520-122Z"/></svg>
                            </a>
                    </form>
                </div>

                    <div class="text-black bg-white w-full h-auto justify-center py-20 px-20 mx-auto flex shadow-lg rounded-lg mt-5 border">
                        @if($teachers->isEmpty())
                        <p class="text-center">No teachers available.</p>
                        @else
                    <table class=" stripe table-auto border-collapse py-10 w-full " id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Teacher Name</th>
                                <th>Skill</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Certification 1</th>
                                <th>Certification 2</th>
                                <th>Certification 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr  class="{{ $loop->even ? 'bg-gray-400' : 'bg-white' }} hover:bg-gray-200">
                                <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border-b px-4 py-2">{{ $teacher->teachers->username ?? 'N/A' }}</td>
                                <td class="border-b px-4 py-2">{{ $teacher->skills->name ?? 'N/A' }}</td>
                                <td class="border-b px-4 py-2">{{ $teacher->skills->type ?? 'N/A' }}</td>
                                <td class="border-b px-4 py-2 text-ellipsis">
                                    {{ Str::limit($teacher->skills->description ?? "Not Found", 50) }}
                                </td>    
                                <td class="border-b px-4 py-2">{{ $teacher->teachers->certifications[0]->name ?? 'No Certification' }}</td>
                                <td class="border-b px-4 py-2">{{ $teacher->teachers->certifications[1]->name ?? 'No Certification' }}</td>
                                <td class="border-b px-4 py-2">{{ $teacher->teachers->certifications[2]->name ?? 'No Certification' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    </div>

                </section>
                    
            </div>


        </div>
    </div>
    </div>
    <script>
         document.addEventListener('alpine:init', () => {
        $('#table').DataTable();
        $('#skillCategory').select2();
        $('#skill').select2();
        $('.select2-selection').css('border','none')
    });
    </script>
   
</x-guest-layout>
