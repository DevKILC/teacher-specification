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
             openRequestPermission: false,
            permission: {
                name: '',
            },
            role: {
                name: '',
            }
        }">

        <div class="py-12 flex-col justify-center">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Top section -->
                <div class="flex justify-between items-center text-left w-full h-16 mt-2 mb-6 bg-white py-5 rounded-md shadow-md">
                    <div class=" flex items-center">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                                <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                            </svg>
                        </span>
                        <h1 class="text-2xl">
                            Permission
                        </h1>
                    </div>
                    <!-- Request Permission Button -->
                    <div class="flex items-center mr-3">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600" @click="openRequestPermission = true">
                            {{ __('Request Permission') }}
                        </button>
                    </div>
                </div>

                <!-- Request Permission Modal -->
                <x-general.modal :open="'openRequestPermission'" :title="__('Request Permission')">
                    <x-general.form-section id="addRequestPermission" :submit="route('request-permission.store')">
                        <x-slot name="form">
                            <!-- Permission Name -->
                            <div class="col-span-6 sm:col-span-4 w-full">
                                <x-label for="permission" value="{{ __('Permission Name') }}" />
                                <input type="hidden" name="userId" value="{{ $userId ?? ''}}">
                                <select class="select-teacher w-48 pb-4 border-gray-300 border rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" name="permission">
                                    <option value="">Choose Permission</option>
                                    @foreach($permissions as $permission)
                                    <option value="{{ $permission->id }}" {{ request('id') == $permission->id ? 'selected' : '' }}>{{ $permission->name }}</option>
                                    @endforeach
                                </select>
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

                <div class="flex h-auto items-center text-center mt-6 mb-6">
                    <span class="bg-white w-16 h-16 flex items-center text-center rounded-md shadow-md mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-7" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                            <path d="M640-160v-280h160v280H640Zm-240 0v-640h160v640H400Zm-240 0v-440h160v440H160Z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl text-left">Request History Data</h1>
                </div>

                <!-- history data table-->

                <!-- history request -->
                <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative flex justify-center">
                    <!-- data Table -->
                    <div class="w-[90%]">
                        <table class="table-auto py-10" id="requestpermissions">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Skill Name</th>
                                    <th>Status</th>
                                    @role('Administrator')
                                    <th>Action</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($histories as $history)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $history->user[0]->name ?? 'Not Found' }}</td>
                                    <td class="border px-4 py-2">{{ $history->permissions[0]->name ?? 'Not Found' }}</td>
                                    <td class="border px-4 py-2 flex flex-row justify-center">
                                        @switch($history->stats)
                                        @case('Pending')
                                        <button class="bg-yellow-400 rounded-md px-3 py-3 text-white">Pending</button>
                                        @break
                                        @case('Accept')
                                        <button class="bg-green-500 rounded-md px-3 py-3 text-white">Accept</button>
                                        @break
                                        @case('Decline')
                                        <button class="bg-red-500 rounded-md px-3 py-3 text-white"> Decline</button>
                                        @break
                                        @default
                                        <button class="bg-gray-500 rounded-md px-3 py-3 text-white">Unknown Status</button>
                                        @endswitch
                                    </td>
                                    @role('Administrator')
                                    <td class="border space-x-3">
                                        @if($history->stats == 'Pending')
                                        <!-- Show Accept and Decline buttons if status is Pending -->
                                        <form action="{{ route('permissions.accept', $permission->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="bg-green-500 rounded-md px-4 py-2 text-white hover:underline">Accept</button>
                                        </form>

                                        <form action="{{ route('permissions.decline', $permission->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="bg-red-500 rounded-md px-4 py-2  text-white hover:underline">Decline</button>
                                        </form>
                                        @elseif($history->stats == 'Accept')
                                        <!-- Show Accepted status -->
                                        <span class="bg-green-500 text-white">Accepted</span>
                                        @elseif($history->stats == 'Decline')
                                        <!-- Show Declined status -->
                                        <span class="bg-red-500"> text-whiteDeclined</span>
                                        @endif
                                    </td>
                                    @endrole
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


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
                            <thead class="bg-yellow-400 text-white">
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
                                            <x-button type="submit">
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
                <!--  -->

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
                        <thead class="bg-yellow-400 text-white">
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
                                    <form action="{{ route('permission.destroyRole', $role->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" class="bg-red-500">
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
                <x-general.form-section id="openRole" :submit="route('permission.storeRole')">
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
                $('#requestpermissions').DataTable();
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