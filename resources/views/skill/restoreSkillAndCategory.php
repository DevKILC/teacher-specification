<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">
            <!-- Header Title -->
            <h2 class="font-medium text-2xl text-gray-800 leading-tight">
                {{ __('Skill & Category') }}
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                            <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl">
                        Data Skills & Categories Preview
                    </h1>
                </div>

                <div class="flex h-auto items-center text-center mt-12 mb-12">
                    <span class="bg-white w-16 h-16 flex items-center text-center rounded-md shadow-md mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl text-left">Skills Data</h1>
                </div>

                <!-- table data -->

                    <!-- Skill -->
                    <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative flex justify-center" >
       
                        <div class="bg-white w-auto h-16 absolute rounded-t-lg -mt-24  right-0 py-3 px-3 ">
                            <x-button>
                                {{ __('Restore Selected Skill') }}
                            </x-button>
                        </div>
                                </div>

                            </form>
                        </x-general.modal>
                        <div class="w-[90%]">
                            <!-- Skill List -->
                            @if($skills->isEmpty())
                            <p>No skills available.</p>
                            @else
                            <table class="table-auto border-collapse py-10" id="skills-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        @can('Manage skill')
                                        <th>Actions</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($skills as $skill)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="border px-4 py-2">{{ $skill->name }}</td>
                                        <td class="border px-4 py-2">{{ $skill->description }}</td>
                                        <td class="border px-4 py-2">{{ $skill->category->name }}</td>
                                        <td class="border px-4 py-2">{{ $skill->type }}</td>
                                        @can('Manage skill')
                                        <td class="border px-4 py-2 flex justify-center space-x-2">
                                            <x-button
                                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                                                @click="
                                                skill = {
                                                    id: {{ $skill->id }},
                                                    name: '{{ $skill->name }}',
                                                    description: '{{ $skill->description }}',
                                                    category_id: {{ $skill->category_id }},
                                                    type: '{{ $skill->type }}'
                                                };
                                                openAddSkillModal = true;
                                            ">
                                                {{ __('EDIT') }}
                                            </x-button>
                                            <form id="deleteSkill" action="{{ route('skill.destroy', $skill->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" id="deleteSkillButton">
                                                    {{__('DELETE')}}
                                                </x-button>
                                            </form>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex h-auto items-center text-center mt-12 mb-12">
                    <span class="bg-white w-16 h-16 flex items-center text-center rounded-md shadow-md mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl text-left">Catgories Data</h1>
                </div>

                <!-- Categories -->
                <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative flex justify-center">     

      
                    <div class="bg-white w-auto h-16 absolute rounded-t-lg -mt-24  right-0 py-3 px-3 ">
                        <x-button>
                            {{ __('Restore Selected Category') }}
                        </x-button>  
                    </div>
        
                    <div class="w-[90%]">
                        <!-- Category List -->
                        @if($categories->isEmpty())
                        <p>No Categories available.</p>
                        @else
                        <table class="table-auto py-10" id="categories-table">
                            <thead class="">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    @can('Manage category')
                                    <th>Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $category->name }}</td>
                                    @can('Manage category')
                                    <td class="border px-4 py-2 flex justify-center space-x-2">
                                        <x-button
                                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                                            @click="
                                            category = {
                                                    id: {{ $category->id }},
                                                    name: '{{ $category->name }}',
                                                };
                                                openAddCategoryModal = true;
                                            ">
                                            {{ __('EDIT') }}
                                        </x-button>
                                        <form id="deleteCategory" action="{{ route('category.destroy', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" id="deleteCategoryButton">
                                                {{__('DELETE')}}
                                            </x-button>
                                        </form>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>


            </div>

    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            $('#skills-table').DataTable();
            $('#categories-table').DataTable();
        });
        // Delete Skill
        document.getElementById('deleteSkillButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent automatic form submission
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this skill?',
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
                        text: 'Please wait while we are deleting the skill',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('deleteSkill').submit(); // Submit form after confirmation
                }
            });
        });

        // Delete Category
        document.getElementById('deleteCategoryButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent automatic form submission
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will also delete all skills associated with this category. Do you want to continue?',
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
                        text: 'Please wait while we are deleting the category',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    document.getElementById('deleteCategory').submit(); // Submit form after confirmation
                }
            });
        });
        // edit and add category loading 
        const editCategoryForm = document.getElementById('editCategory');
        if (editCategoryForm) {
            editCategoryForm.addEventListener('submit', function() {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we updating the category',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        }
        const addCategoryForm = document.getElementById('addCategory');
        if (addCategoryForm) {
            addCategoryForm.addEventListener('submit', function() {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we adding the category',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }

                });
            });
        }
        // edit and add new skill
        const editSkillForm = document.getElementById('editSkill');
        if (editSkillForm) {
            editSkillForm.addEventListener('submit', function() {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we updating the skill',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        }
        const addSkillForm = document.getElementById('addSkill');
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
    </script>
</x-app-layout>