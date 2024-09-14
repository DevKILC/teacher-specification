<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">
            <!-- Header Title -->
            <h2 class="font-medium text-2xl text-gray-800 leading-tight">
                {{ __('Skill & Category') }}
            </h2>
        </div>
    </x-slot>

    <div x-data="{ 
            openSkillModal: false, 
            openCategoryModal: false,
            openAddSkillModal: false,
            openAddCategoryModal: false,
            skill: {
                id: 0,
                name: '',
                description: '',
                category_id: null,
                type: ''
            },
            category: {
                id: 0,
                name: ''
            },
        }">

        {{-- SKILLS --}}
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end py-10">
                <x-button @click="openSkillModal = true">
                    {{ __('Add Skill') }}
                </x-button>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Skill List -->
                @if($skills->isEmpty())
                <p>No skills available.</p>
                @else
                <table class="table-auto py-10" id="skills-table">
                    <thead  class="bg-yellow-400 text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Actions</th>
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
                            <td class="border px-4 py-2 flex space-x-2">
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        {{-- CATEGORIES --}}
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end py-10">
                <x-button @click="openCategoryModal = true">
                    {{ __('Add Category') }}
                </x-button>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Category List -->
                @if($categories->isEmpty())
                <p>No Categories available.</p>
                @else
                <table class="table-auto py-10" id="categories-table">
                    <thead  class="bg-yellow-400 text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $category->name }}</td>
                            <td class="border px-4 py-2 flex space-x-2">
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        <!-- Skill Modal -->
        <!-- ADD -->
        <x-general.modal :open="'openSkillModal'" :title="__('Create Skill')">
            <x-general.form-section id="addSkill" :submit="route('skill.store')">
                <x-slot name="form">
                    <!-- Skill Name -->
                    <div class="col-span-6 sm:col-span-4 w-full">
                        <x-label for="name" value="{{ __('Skill Name') }}" />
                        <x-input id="skillName" class="w-full" type="text" name="name" x-model="skill.name" value="{{ old('name') }}" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <!-- Skill Description -->
                    <div class="col-span-6 sm:col-span-4 w-full">
                        <x-label for="description" value="{{ __('Skill Description') }}" />
                        <x-text-area id="skillDescription" class="w-full" name="description" rows="3" x-model="skill.description" required>{{ old('description') }}</x-textarea>
                            <x-input-error for="description" class="mt-2" />
                    </div>

                    <!-- Skill Category -->
                    <div class="col-span-6 sm:col-span-4 w-full">
                        <x-label for="category_id" value="{{ __('Skill Category') }}" />
                        <select id="skillCategory" class="w-full" name="category_id" x-model="skill.category_id" required>
                            <option value="">{{ __('Select a category') }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        <x-input-error for="category_id" class="mt-2" />
                    </div>

                    <!-- Skill Type -->
                    <div class="col-span-6 sm:col-span-4 w-full">
                        <x-label for="type" class="w-full" value="{{ __('Type') }}" />
                        <select id="type" name="type" x-model="skill.type" required>
                            <option value="">{{ __('Select Type') }}</option>
                            <option value="ONLINE" {{ old('type') == 'ONLINE' ? 'selected' : '' }}>{{ __('Online') }}</option>
                            <option value="OFFLINE" {{ old('type') == 'OFFLINE' ? 'selected' : '' }}>{{ __('Offline') }}</option>
                        </select>
                        <x-input-error for="type" class="mt-2" />
                    </div>
                </x-slot>

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

        <!-- EDIT -->
        <x-general.modal :open="'openAddSkillModal'" :title="__('Update Skill')">
            <form id="editSkill" :action="'{{ route('skill.update', '') }}/' + skill.id" method="POST">
                @csrf
                @method('PUT')

                <div class="px-4 py-5 bg-white sm:p-6 shadow  sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <!-- Form Fields -->
                        <div class="col-span-6 sm:col-span-4 w-full">
                            <x-label for="name" value="{{ __('Skill Name') }}" />
                            <x-input id="skillName" class="w-full" type="text" name="name" x-model="skill.name" required />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4 w-full">
                            <x-label for="description" value="{{ __('Skill Description') }}" />
                            <x-text-area class="w-full" id="skillDescription" name="description" rows="3" x-model="skill.description" required></x-textarea>
                                <x-input-error for="description" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4 w-full">
                            <x-label for="category_id" value="{{ __('Skill Category') }}" />
                            <select class="w-full" id="skillCategory" name="category_id" x-model="skill.category_id" required>
                                <option value="">{{ __('Select a category') }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error for="category_id" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4 w-full">
                            <x-label for="type" value="{{ __('Type') }}" />
                            <select class="w-full" id="type" name="type" x-model="skill.type" required>
                                <option value="">{{ __('Select Type') }}</option>
                                <option value="ONLINE" {{ old('type') == 'ONLINE' ? 'selected' : '' }}>{{ __('Online') }}</option>
                                <option value="OFFLINE" {{ old('type') == 'OFFLINE' ? 'selected' : '' }}>{{ __('Offline') }}</option>
                            </select>
                            <x-input-error for="type" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex flex-row gap-5 items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <x-button type="button" class="bg-red-500 text-white hover:bg-red-600" @click="openAddSkillModal = false">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button type="submit" class="bg-blue-500 text-white hover:bg-blue-600">
                        {{ __('Update') }}
                    </x-button>
                </div>

            </form>
        </x-general.modal>

        <!-- Category Modal -->
        <!-- ADD -->
        <x-general.modal :open="'openCategoryModal'" :title="__('Create Category')">
            <x-general.form-section id="addCategory" :submit="route('category.store')">
                <x-slot name="form">
                    <!-- Category Name -->
                    <div class="col-span-6 sm:col-span-4 w-full">
                        <x-label for="name" value="{{ __('Category Name') }}" />
                        <x-input class="w-full" id="categoryName" type="text" name="name" value="{{ old('name') }}" required />
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
        <x-general.modal :open="'openAddCategoryModal'" :title="__('Update Category')">
            <form id="editcategory" :action="'{{ route('category.update', '') }}/' + category.id" method="POST">
                @csrf
                @method('PUT')

                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="grid grid-cols-6 gap-6">
                        <!-- Form Fields -->
                        <div class="col-span-6 sm:col-span-4 w-full">
                            <x-label for="name" value="{{ __('Category Name') }}" />
                            <x-input class="w-full" id="categoryName" type="text" name="name" x-model="category.name" required />
                            <x-input-error for="name" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex flex-row gap-5 items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <x-button type="button" class="bg-red-500 text-white hover:bg-red-600" @click="openAddCategoryModal = false">
                        {{ __('Cancel') }}
                    </x-button>
                    <x-button type="submit" class="bg-blue-500 text-white hover:bg-blue-600">
                        {{ __('Update') }}
                    </x-button>
                </div>

            </form>
        </x-general.modal>
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