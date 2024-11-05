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
                <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative flex justify-center"
                    x-data="{
                        openAddSkillModal: false,
                        editSkillModal: false,
                        skill: {
                            id: 0,
                            name: '',
                            description: '',
                            category_id: null,
                            type: ''
                        },
                    }">
                    @if (userHasPath('add-skill'))
                        <div class="bg-white w-auto h-16 absolute rounded-t-lg -mt-24  right-0 py-3 px-3 ">
                            <x-button @click="openAddSkillModal = true">
                                {{ __('Add Skill') }}
                            </x-button>
                        </div>
                    @endif
                    <!-- Skill Modal -->
                    <!-- ADD -->
                    <x-general.modal :open="'openAddSkillModal'" :title="__('Create Skill')">
                        <x-general.form-section id="addSkill" :submit="route('skill.store')">
                            <x-slot name="form">
                                <!-- Skill Name -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="name" value="{{ __('Skill Name') }}" />
                                    <x-input id="skillName" class="w-full" type="text" name="name"
                                        x-model="skill.name" value="{{ old('name') }}" required />
                                    <x-input-error for="name" class="mt-2" />
                                </div>

                                <!-- Skill Description -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="description" value="{{ __('Skill Description') }}" />
                                    <x-text-area id="skillDescription" class="w-full text-ellipsis"
                                        style="border-radius:5px ;  border-style: solid;
  border-color: gray;"
                                        name="description" rows="3" x-model="skill.description"
                                        required>{{ old('description') }}</x-textarea>
                                        <x-input-error for="description" class="mt-2" />
                                </div>

                                <!-- Skill Category -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="category_id" value="{{ __('Skill Category') }}" />
                                    <select style="border-radius:5px ;  border-style: solid;
  border-color: gray;"
                                        id="skillCategory" class="w-full" name="category_id" x-model="skill.category_id"
                                        required>
                                        <option value="">{{ __('Select a category') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="category_id" class="mt-2" />
                                </div>

                                <!-- Skill Type -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="type" class="w-full" value="{{ __('Type') }}" />
                                    <select id="type" class="w-full"
                                        style="border-radius:5px ;  border-style: solid;
  border-color: gray;"
                                        name="type" x-model="skill.type" required>
                                        <option value="">{{ __('Select Type') }}</option>
                                        <option value="ONLINE" {{ old('type') == 'ONLINE' ? 'selected' : '' }}>
                                            {{ __('Online') }}</option>
                                        <option value="OFFLINE" {{ old('type') == 'OFFLINE' ? 'selected' : '' }}>
                                            {{ __('Offline') }}</option>
                                    </select>
                                    <x-input-error for="type" class="mt-2" />
                                </div>
                            </x-slot>

                            <x-slot name="actions">
                                <x-button class="bg-blue-500 text-white hover:bg-blue-600">
                                    {{ __('Save') }}
                                </x-button>
                                <x-button type="button" class="ml-4" @click="openAddSkillModal = false">
                                    {{ __('Cancel') }}
                                </x-button>
                            </x-slot>
                        </x-general.form-section>
                    </x-general.modal>
                 
                    <div class="w-[90%]"   x-data="{
                        editSkillModal: false,
                        skill: {
                            id: 0,
                            name: '',
                            description: '',
                            category_id: null,
                            type: ''
                        },
                    }">
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
                                        @if (userHasPath('detail-skill'))
                                            <th>Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($skills as $skill)
                                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200">
                                            <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                            <td class="border-b px-4 py-2">{{ $skill->name ?? 'Not Found' }}</td>
                                            <td class="border-b px-4 py-2 text-ellipsis">
                                                {{ Str::limit($skill->description ?? 'Not Found', 50) }}
                                            </td>
                                            <td class="border-b px-4 py-2">{{ $skill->category->name ?? 'Not Found' }}
                                            </td>
                                            <td class="border-b px-4 py-2">{{ $skill->type ?? 'Not Found' }}</td>
                                            @if (userHasPath('detail-skill'))
                                                <td class="border-b px-4 py-2 flex justify-center space-x-2">
                                                    <x-button
                                                        @click="
                                                    skill = {
                                                        id: {{ $skill->id }},
                                                        name: '{{ $skill->name ?? 'Unnamed Skill' }}',
                                                        description: '{{ $skill->description ?? 'No description available' }}',
                                                        category_id: {{ $skill->category_id }},
                                                        type: '{{ $skill->type ?? 'Unknown' }}'
                                                    };
                                                    editSkillModal = true;
                                                ">
                                                        {{ __('EDIT') }}
                                                    </x-button>

                                                       <!-- EDIT -->
                                                       {{-- modal --}}
                                                       <x-general.modal :open="'editSkillModal'" :title="__('Update Skill')" >
                                                        <form id="editSkill" :action="'{{ route('skill.update', '') }}/' + skill.id" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                
                                                            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                                                <div class="grid grid-cols-6 gap-6">
                                                
                                                                    <!-- Skill Name -->
                                                                    <div class="col-span-6 sm:col-span-4 w-full">
                                                                        <x-label for="name" value="{{ __('Skill Name') }}" />
                                                                        <x-input id="skillName" class="w-full" type="text" name="name"
                                                                                 x-model="skill.name" required />
                                                                        <x-input-error for="name" class="mt-2" />
                                                                    </div>
                                                
                                                                    <!-- Skill Description -->
                                                                    <div class="col-span-6 sm:col-span-4 w-full">
                                                                        <x-label for="description" value="{{ __('Skill Description') }}" />
                                                                        <x-text-area id="skillDescription" name="description" rows="3"
                                                                                     class="w-full border-gray-300 rounded"
                                                                                     x-model="skill.description" required></x-text-area>
                                                                        <x-input-error for="description" class="mt-2" />
                                                                    </div>
                                                
                                                                    <!-- Skill Category -->
                                                                    <div class="col-span-6 sm:col-span-4 w-full">
                                                                        <x-label for="category_id" value="{{ __('Skill Category') }}" />
                                                                        <select id="skillCategory" name="category_id" x-model="skill.category_id" required
                                                                                class="w-full border-gray-300 rounded">
                                                                            <option value="">{{ __('Select a category') }}</option>
                                                                            @foreach ($categories as $category)
                                                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                                                    {{ $category->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <x-input-error for="category_id" class="mt-2" />
                                                                    </div>
                                                
                                                                    <!-- Skill Type -->
                                                                    <div class="col-span-6 sm:col-span-4 w-full">
                                                                        <x-label for="type" value="{{ __('Type') }}" />
                                                                        <select id="type" name="type" x-model="skill.type" required
                                                                                class="w-full border-gray-300 rounded">
                                                                            <option value="">{{ __('Select Type') }}</option>
                                                                            <option value="ONLINE" {{ old('type') == 'ONLINE' ? 'selected' : '' }}>{{ __('Online') }}</option>
                                                                            <option value="OFFLINE" {{ old('type') == 'OFFLINE' ? 'selected' : '' }}>{{ __('Offline') }}</option>
                                                                        </select>
                                                                        <x-input-error for="type" class="mt-2" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                
                                                            <!-- Save Button -->
                                                            <div class="flex justify-end gap-5 px-4 py-3 bg-gray-50 sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                                                                <x-button type="button" class="bg-red-500 text-white hover:bg-red-600" @click="editSkillModal = false">
                                                                    {{ __('Cancel') }}
                                                                </x-button>
                                                                <x-button type="submit" class="bg-blue-500 text-white hover:bg-blue-600">
                                                                    {{ __('Update') }}
                                                                </x-button>
                                                            </div>
                                                
                                                        </form>
                                                    </x-general.modal>

                                                    <form id="deleteSkill"
                                                        action="{{ route('skill.destroy', $skill->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-button type="submit" id="deleteSkillButton">
                                                            {{ __('DELETE') }}
                                                        </x-button>
                                                    </form>
                                                </td>
                                            @endif
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7" height="24px" viewBox="0 -960 960 960"
                        width="24px" fill="#5f6368">
                        <path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z" />
                    </svg>
                </span>
                <h1 class="text-2xl text-left">Categories Data</h1>
            </div>

            <!-- Categories -->
            <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative flex justify-center"
                x-data="{
                    openCategoryModal: false,
                    openEditCategory: false,
                    category: {
                        id: 0,
                        name: ''
                    },
                }">

                @if (userHasPath('add-category-skill'))
                    <div class="bg-white w-auto h-16 absolute rounded-t-lg -mt-24  right-0 py-3 px-3 ">
                        <x-button @click="openCategoryModal = true">
                            {{ __('Add Category') }}
                        </x-button>
                @endif
                <!-- Category Modal -->
                <!-- ADD -->
                <x-general.modal :open="'openCategoryModal'" :title="__('Create Category')">
                    <x-general.form-section id="addCategory" :submit="route('category.store')">
                        <x-slot name="form">
                            <!-- Category Name -->
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <x-label for="name" value="{{ __('Category Name') }}" />
                                <x-input class="w-full" id="categoryName" type="text" name="name"
                                    value="{{ old('name') }}" required />
                                <x-input-error for="name" class="mt-2" />
                            </div>
                        </x-slot>

                        <x-slot name="actions">
                            <x-button class="bg-blue-500 text-white hover:bg-blue-600">
                                {{ __('Save') }}
                            </x-button>
                            <x-button type="button" class="ml-4" @click="openCategoryModal = false">
                                {{ __('Cancel') }}
                            </x-button>
                        </x-slot>
                    </x-general.form-section>
                </x-general.modal>

                <!-- EDIT -->
                <x-general.modal :open="'openEditCategory'" :title="__('Update Category')">
                    <form id="editcategory" :action="'{{ route('category.update', '') }}/' + category.id"
                        method="POST">
                        @csrf
                        @method('PUT')

                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <!-- Form Fields -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="name" value="{{ __('Category Name') }}" />
                                    <x-input class="w-full" id="categoryName" type="text" name="name"
                                        x-model="category.name" required />
                                    <x-input-error for="name" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div
                            class="flex flex-row gap-5 items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <x-button type="button" class="bg-red-500 text-white hover:bg-red-600"
                                @click="openEditCategory = false">
                                {{ __('Cancel') }}
                            </x-button>
                            <x-button type="submit" class="bg-blue-500 text-white hover:bg-blue-600">
                                {{ __('Update') }}
                            </x-button>
                        </div>

                    </form>
                </x-general.modal>
            </div>

            <div class="w-[90%]">
                <!-- Category List -->
                @if ($categories->isEmpty())
                    <p>No Categories available.</p>
                @else
                    <table class="stripe table-auto py-10" id="categories-table">
                        <thead class="">
                            <tr>
                                <th class="text-left">ID</th>
                                <th>Name</th>
                                @if (userHasPath('detail-category-skill'))
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200">
                                    <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border-b px-4 py-2">{{ $category->name ?? 'Not Found' }}</td>
                                    @if (userHasPath('detail-category-skill'))
                                        <td class="border-b px-4 py-2 flex justify-center space-x-2">
                                            <x-button
                                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                                                @click="
                                            category = {
                                                    id: '{{ $category->id }}',
                                                    name: '{{ $category->name }}',
                                                };
                                                openEditCategory = true;
                                            ">
                                                {{ __('EDIT') }}
                                            </x-button>
                                            <form id="deleteCategory"
                                                action="{{ route('category.destroy', $category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" id="deleteCategoryButton">
                                                    {{ __('DELETE') }}
                                                </x-button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>


        {{-- Restore Skill Button --}}
        @if (userHasAction('restore-skill-category:show'))
            <a href="{{ route('restore-skill-category.index') }}">
                @csrf
                <button
                    class="text-center rounded-md text-white font-medium w-full h-auto mt-12 mb-12 py-4 shadow-md bg-yellow-400 hover:bg-yellow-500">
                    Restore Skills or Categories Data
                </button>
            </a>
        @endif




    </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

          

      
                $('#skills-table').DataTable();
                $('#categories-table').DataTable();
       

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
                        document.getElementById('deleteSkill')
                    .submit(); // Submit form after confirmation
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
                        document.getElementById('deleteCategory')
                    .submit(); // Submit form after confirmation
                    }
                });
            });

        });
    </script>
</x-app-layout>
