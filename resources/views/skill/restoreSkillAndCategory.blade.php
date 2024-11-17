<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">
            <!-- Header Title -->
            <h2 class="font-medium text-2xl text-gray-800 leading-tight">
                <a href="{{ route('skill.index') }}">{{ __('Skill & Category') }}</a> - {{ __('Restore') }}
            </h2>   
        </div>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <!-- Content -->
                <!-- Wrapper card -->
                <div class="flex items-center text-left w-full h-16 mt-12 bg-white py-5 rounded-md shadow-md">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-16" height="24px" viewBox="0 -960 960 960"
                            width="24px" fill="#000000">
                            <path
                                d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl">
                        Data Skills & Categories Preview
                    </h1>
                </div>

                <div class="flex h-auto items-center text-center mt-12 mb-12">
                    <span class="bg-white w-16 h-16 flex items-center text-center rounded-md shadow-md mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7" height="24px" viewBox="0 -960 960 960"
                            width="24px" fill="#5f6368">
                            <path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl text-left">Skills Data</h1>
                </div>

                <!-- table data -->

                <!-- Skill -->
                <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative">
                    <form action="{{ route('restore-skill-category.restore') }}" method="POST" id="restoreSkill">
                        @csrf
                        @method('PUT') <!-- Menggunakan metode spoofing untuk PUT -->
                        <div class="bg-white w-auto h-16 absolute rounded-t-lg -mt-24  right-0 py-3 px-3 "  id="restoreSkill">
                            <x-button>
                                {{ __('Restore Selected Skill') }}
                            </x-button>
                        </div>

                        <div class="w-[90%] mx-auto">
                            <!-- Skill List -->
                            @if ($skills->isEmpty())
                                <p>No skills available.</p>
                            @else
                                <table class="stripe table-auto border-collapse py-10" id="skills-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Type</th>

                                            <th>Select All <input class="ml-3" type="checkbox" id="select-all"></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($skills as $skill)
                                            <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200">
                                                <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                                <td class="border-b px-4 py-2">{{ $skill->name }}</td>
                                                <td class="border-b px-4 py-2 text-ellipsis">
                                                    {{ Str::limit($skill->description ?? "Not Found", 50) }}
                                                </td>                
                                                <td class="border-b px-4 py-2">{{ $skill->category->name ?? 'Not Found , You need to restore category first' }}</td>
                                                <td class="border-b px-4 py-2">{{ $skill->type }}</td>

                                                <td class="border-b px-4 py-2 text-center align-middle">

                                                    <input type="checkbox" name="skill[]" value="{{ $skill->id }}"
                                                        class="skill-checkbox">

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                </div>
                </form>
            </div>

            <div class="flex h-auto items-center text-center mt-12 mb-12">
                <span class="bg-white w-16 h-16 flex items-center text-center rounded-md shadow-md mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7" height="24px" viewBox="0 -960 960 960"
                        width="24px" fill="#5f6368">
                        <path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z" />
                    </svg>
                </span>
                <h1 class="text-2xl text-left">Categories Data</h1>
            </div>

            <!-- Categories -->
            <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative">
                <form action="{{ route('restore-skill-category.restore') }}" method="POST" id="restoreCategory">
                    @csrf
                    @method('PUT') <!-- Menggunakan metode spoofing untuk PUT -->
                    <div class="bg-white w-auto h-16 absolute rounded-t-lg -mt-24  right-0 py-3 px-3 " >
                        <x-button id="restoreCategory">
                            {{ __('Restore Selected Category') }}
                        </x-button>
                    </div>

                    <div class="w-[90%] mx-auto">
                        <!-- Category List -->
                        @if ($categories->isEmpty())
                            <p>No Categories available.</p>
                        @else
                            <table class="stripe table-auto py-10" id="categories-table">
                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>

                                        <th>Select All <input class="ml-3" type="checkbox" id="select-category">
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200">
                                            <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                            <td class="border-b px-4 py-2">{{ $category->name }}</td>
                                            <td class="border-b px-4 py-2 text-center align-middle">
                                                <input type="checkbox" name="category[]" value="{{ $category->id }}" class="category-checkbox">
                                            </td>
                                            
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </form>
            </div>




        </div>

    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            $('#skills-table').DataTable();
            $('#categories-table').DataTable();
        });

        // Select all checkboxes functionality
        document.getElementById('select-all').addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('.skill-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
        // Select all checkboxes functionality
        document.getElementById('select-category').addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('.category-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });


        
        const restoreCategoryForm = document.getElementById('restoreCategory');
        if (restoreCategoryForm) {
            restoreCategoryForm.addEventListener('submit', function() {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we Restoring the category',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }

                });
            });
        }
       
        const restoreSkillForm = document.getElementById('restoreSkill');
        if (restoreSkillForm) {
            restoreSkillForm.addEventListener('submit', function() {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we Restoring the skill',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        }
    </script>
</x-app-layout>
