<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">
            <!-- Header Title -->
            <h2 class="font-medium text-2xl text-gray-800 leading-tight">
                {{ __('Permission') }}
            </h2>
        </div>
    </x-slot>

    <div x-data="{ 
            openAddPermission: false, 
            openRole: false,
            permission: {
                name: '',
            },
            role: {
                name: '',
            }
        }">

        {{-- PERMISSIONS --}}
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end py-10">
                <x-button @click="openAddPermission = true">
                    {{ __('Add Permission') }}
                </x-button>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Skill List -->
                @if($permissions->isEmpty())
                <p>No Permission available.</p>
                @else
                <table class="table-auto py-10" id="permissions-table">
                    <thead  class="bg-yellow-400 text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $permission->name }}</td>
                            <td class="border px-4 py-2 flex space-x-2">
                                {{-- <x-button
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
                                </x-button> --}}
                                <form action="{{ route('permission.destroy', $permission->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" >
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

        {{-- Role --}}
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end py-10">
                <x-button @click="openRole = true">
                    {{ __('Add Role') }}
                </x-button>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Category List -->
                @if($roles->isEmpty())
                <p>No Roles available.</p>
                @else
                <table class="table-auto py-10" id="roles-table">
                    <thead  class="bg-yellow-400 text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $role->name }}</td>
                            <td class="border px-4 py-2 flex space-x-2">
                                <a href="{{ route('permission.edit-role-permission', $role->id ) }}">
                                    <x-button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                        {{ __('EDIT PERMISSION') }}
                                    </x-button>
                                </a>
                                <form  action="{{ route('permission.destroyRole', $role->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" class="bg-red-500" >
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

        <!-- PERMISSION Modal -->
        <!-- ADD -->
        <x-general.modal :open="'openAddPermission'" :title="__('Permission')">
            <x-general.form-section id="addPermission" :submit="route('permission.store')">
                <x-slot name="form">
                    <!-- Permission Name -->
                    <div class="col-span-6 sm:col-span-4 w-full">
                        <x-label for="name" value="{{ __('Permission Name') }}" />
                        <x-input id="permissionName" class="mt-1 w-full" type="text" name="name" :value="old('email')" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                </x-slot>

                <x-slot name="actions">
                    <x-button class="bg-blue-500 text-white hover:bg-blue-600">
                        {{ __('Save') }}
                    </x-button>
                    <x-button type="button" class="ml-4" @click="openAddPermission = false">
                        {{ __('Cancel') }}
                    </x-button>
                </x-slot>
            </x-general.form-section>
        </x-general.modal>
        

        <!-- Role Modal -->
        <!-- ADD -->
        <x-general.modal :open="'openRole'" :title="__('Role')">
            <x-general.form-section id="openRole" :submit="route('permission.storeRole')" >
                <x-slot name="form">
                    <!-- Permission Name -->
                    <div class="col-span-6 sm:col-span-4 w-full">
                        <x-label for="name" value="{{ __('Role Name') }}" />
                        <x-input id="roleName" class="mt-1 w-full" type="text" name="name" :value="old('name')" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                </x-slot>

                <x-slot name="actions">
                    <x-button class="bg-blue-500 text-white hover:bg-blue-600">
                        {{ __('Save') }}
                    </x-button>
                    <x-button type="button" class="ml-4" @click="openRole = false">
                        {{ __('Cancel') }}
                    </x-button>
                </x-slot>
            </x-general.form-section>
        </x-general.modal>
       
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            $('#permissions-table').DataTable();
            $('#roles-table').DataTable();
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
        const addSkillForm = document.getElementById('addPermission');
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