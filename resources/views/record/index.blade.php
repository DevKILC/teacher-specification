<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Records') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-y-14">

            <div class="flex items-center text-left w-full h-16 mt-12 bg-white py-5 rounded-md shadow-md">

                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-16" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000">
                        <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                    </svg>
                </span>
                <h1 class="text-2xl">
                    Activity Records
                </h1>

            </div>
            @role('Administrator')
            <div class="mt-1">
            </div>
@endrole
            <!--  -->
            <div class="w-full bg-white shadow-md rounded-md h-auto py-10 relative mt-auto flex justify-center" x-data="{ openAddTeacherActivity: false, openAddActivityCategory: false }">
            @role('Administrator')
                <!-- addactivity button and add activity category button  -->
                <!-- addactivity button -->
                <div class="bg-white w-auto space-x-3 h-16 absolute rounded-t-lg -mt-24 flexn left-0 py-3 px-3 ">
                    <button @click="openAddTeacherActivity = true" class="bg-yellow-400 text-white hover:bg-yellow-500 py-2 px-4 rounded-md w-30 h-10">
                        Add Teacher Activity
                    </button>

                    <!-- Teacher Activity Modal -->
                    <x-general.modal :open="'openAddTeacherActivity'" :title="__('Create Activity')">
                        <x-general.form-section id="addActivity" :submit="route('record.store')">
                            <x-slot name="form">
                                <x-slot name="title">
                                    {{ __('Add Teacher Activity') }}
                                </x-slot>

                                <!-- Teacher Name -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="id" class="w-full value=" {{ __('Teacher Name') }}" />
                                    <select id="select-teacher" name="id" class="w-full">
                                        <option value="">Choose Teacher</option>
                                        @foreach($allTeachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ request('id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="id" class="mt-2" />
                                </div>

                                <!-- Activity Description -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="activity" class="w-full value=" {{ __('Activity') }}" />
                                    <x-text-area name="activity" rows="3" required></x-text-area>
                                    <x-input-error for="description" class="mt-2" />
                                </div>

                                <!-- Category -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="category_id" value="{{ __('Activity Category') }}" />
                                    <select id="activityCategory" class="w-full" name="category_id" required>
                                        <option value="">{{ __('Select a category') }}</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <x-input-error for="category_id" class="mt-2" />
                                </div>

                                <!-- Date -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="date" value="{{ __('Activity Date') }}" />
                                    <input type="date" class="w-full" name="date" required />
                                    <x-input-error for="date" class="mt-2" />
                                </div>

                            </x-slot>
                            <x-slot name="actions">
                                <x-button class="bg-blue-500 text-white hover:bg-blue-600">
                                    {{ __('Save') }}
                                </x-button>
                                <x-button type="button" class="ml-4" @click="openAddTeacherActivity = false">
                                    {{ __('Cancel') }}
                                </x-button>
                            </x-slot>

                        </x-general.form-section>
                    </x-general.modal>

                    <!-- addcategory button -->
                    <button @click="openAddActivityCategory = true" class="bg-yellow-400 text-white hover:bg-yellow-500 py-2 px-4 rounded-md w-30 h-10">
                        Add Activity Category
                    </button>

                    <x-general.modal :open="'openAddActivityCategory'" :title="__('Create Category')">
                        <!-- modalshow category -->
                        <div class="" x-data="{openActivityCategory : false}">
                            <!-- button show category -->
                            <button @click="openActivityCategory = true" class="bg-yellow-400 mb-5 mt-5 text-white hover:bg-yellow-500 py-2 px-4 rounded-md w-30 h-10">
                                {{ __('Show Category') }}
                            </button>
                            <!-- Modal Component -->
                            <x-general.modal :open="'openActivityCategory'" :title="__('Categories List')">
                                <!-- Category Table -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <table class="table-auto w-full py-10" id="activitycategory-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                @role('Administrator')
                                                <th>Option</th>
                                                @endrole
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categories as $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $category->name ?? 'N/A' }}</td>
                                                @role('Administrator')
                                                <td class="flex justify-center">
                                                    <!-- Form to Delete Category -->
                                                    <form id="deleteActivityCategory" action="{{ route('categoryactivity.destroy', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-button type="submit" id="deteleActivityCategoryButton">
                                                            {{ __('DELETE') }}
                                                        </x-button>
                                                    </form>
                                                </td>
                                                @endrole
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal Actions -->
                                <x-slot name="actions">
                                    <x-button type="button" class="ml-4" @click="openActivityCategory = false">
                                        {{ __('Back') }}
                                    </x-button>
                                </x-slot>
                            </x-general.modal>
                        </div>
                        <x-general.form-section id="addCategory" :submit="route('categoryactivity.store')">
                            <x-slot name="form">
                                <!-- Category Name -->
                                <div class="col-span-6 sm:col-span-4 w-full">
                                    <x-label for="name" value="{{ __('Category Name') }}" />
                                    <x-input id="name" type="text" class="w-full" name="name" value="{{ old('name') }}" required />
                                    <x-input-error for="name" class="mt-2" />
                                </div>

                            </x-slot>

                            <x-slot name="actions">
                                <x-button class="bg-blue-500 text-white hover:bg-blue-600">
                                    {{ __('Save') }}
                                </x-button>
                                <x-button type="button" class="ml-4" @click="openAddActivityCategory = false">
                                    {{ __('Cancel') }}
                                </x-button>
                            </x-slot>
                        </x-general.form-section>
                    </x-general.modal>

                </div>
                @endrole
               
                <div class="flex flex-col w-full justify-center">
                    <!-- date filter -->
                    <div class="w-full h-16 flex justify-end ">
                        <form id="dateFilter" class="flex flex-row w-[50%] items-center gap-x-4 pr-4 " action="{{ route('record.index') }}" method="GET">
                            <!-- Date From -->
                            <input type="date" name="start" value="{{ request('start') }}" class="border-2 border-gray-300 rounded-md px-4 py-2 w-full" require />
                            <!-- Date To -->
                            <input type="date" name="end" value="{{ request('end') }}" class="border-2 border-gray-300 rounded-md px-4 py-2 w-full" require />

                            <button type="submit" class="bg-yellow-400 text-white hover:bg-yellow-500 py-2 px-4 rounded-md">
                                Filter
                            </button>
                            <a href="{{ route('record.index') }}" class="bg-red-600 text-white hover:bg-red-700 py-2 px-4 rounded-md text-center">
                                Reset
                            </a>
                        </form>
                    </div>
                            <div class="h-10"></div>
                    <!-- table Activity -->
                    @if($allActivities->isEmpty())
                    <p class="text-center">No Activity available.</p>
                    @else
                    <div class=" ml-14 w-[90%] pt-10 h-full">
                        <table class="table-auto w-full py-10" id="activity-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Activity</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    @role('Administrator')
                                    <th>Option</th>
                                    @endrole

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allActivities as $activity)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $activity->teachers->name ?? 'N/A' }}</td>
                                    <td>{{ $activity->activity ?? 'N/A' }}</td>
                                    <td>{{ $activity->category->name ?? 'N/A' }}</td>
                                    <td>{{ $activity->date ?? 'N/A' }}</td>
                                    @role('Administrator')
                                    <td class="flex justify-center">
                                        <form id="deleteActivity" action="{{ route('record.destroy', $activity->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" id="deteleActivityButton">
                                                {{__('DELETE')}}
                                            </x-button>
                                        </form>
                                    </td>
                                    @endrole
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>

            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    $('#activity-table').DataTable();
                });
                document.addEventListener('alpine:init', () => {
                    $('#activitycategory-table').DataTable();
                });

                document.getElementById('deleteActivityButton').addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent automatic form submission
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Are you sure you want to delete this activity?',
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
                                text: 'Please wait while we are deleting the activity',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            document.getElementById('deleteActivity').submit(); // Submit form after confirmation
                        }
                    });
                });

                const addActivityForm = document.getElementById('addActivity');
                if (addActivityForm) {
                    addActivityForm.addEventListener('submit', function() {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait....',
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



                const dateFilterForm = document.getElementById('dateFilter');
                if (dateFilterForm) {
                    dateFilterForm.addEventListener('submit', function() {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Looking for databases...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    });
                }
            </script>
</x-app-layout>