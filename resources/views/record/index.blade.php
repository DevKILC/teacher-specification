<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Records') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col">
            <div class="w-full flex lg:flex-row lg:float-right gap-x-5 my-5" x-data="{ openAddTeacherActivity: false, openAddActivityCategory: false }">
                <!-- Button & Modal Add Teacher Activities  -->
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

                <!-- Button & Modal Add Activity Category -->
                <button @click="openAddActivityCategory = true" class="bg-yellow-400 text-white hover:bg-yellow-500 py-2 px-4 rounded-md w-30 h-10">
                    Add Activity Category
                </button>
                <x-general.modal :open="'openAddActivityCategory'" :title="__('Create Category')" >
                    <!-- modalshow category -->
                    <div class="" x-data="{openActivityCategory : false}">
                    <!-- button show category -->
                    <button @click="openActivityCategory = true" class="bg-yellow-400 mb-5 mt-5 text-white hover:bg-yellow-500 py-2 px-4 rounded-md w-30 h-10">
                        {{ __('Show Category') }}
                    </button>
                    <!-- Modal Component -->
                    <x-general.modal  :open="'openActivityCategory'" :title="__('Categories List')">
                        <!-- Category Table -->
                        <div class="col-span-6 sm:col-span-4 w-full">
                            <table class="table-auto w-full py-10" id="activity-table">
                                <thead class="bg-yellow-400 text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name ?? 'N/A' }}</td>
                                        <td>
                                            <!-- Form to Delete Category -->
                                            <form id="deleteActivityCategory" action="{{ route('categoryactivity.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" id="deteleActivityCategoryButton">
                                                    {{ __('DELETE') }}
                                                </x-button>
                                            </form>
                                        </td>
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

            <!-- Activity Records -->
            <div class="w-full bg-white shadow-md rounded-md h-auto pb-30">
                <div class="flex flex-col justify-center lg:flex-row lg:justify-between item-center px-5 py-5">
                    <!-- Header Title -->
                    <h1 class="text-xl font-light">Records Activity</h1>

                    <!-- Date range filter -->
                    <div class="w-[50%]">
                        <form id="dateFilter" class="flex flex-row w-full items-center gap-x-2" action="{{ route('record.index') }}" method="GET">
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


                </div>
                <div class="bg-white w-full h-auto pb-10 mt-9 mx-auto flex flex-col shadow-md rounded-md">
                    @if($allActivities->isEmpty())
                    <p class="text-center">No Activity available.</p>
                    @else
                    <div class="w-[90%] h-full mx-auto">
                        <table class="table-auto w-full py-10" id="activity-table">
                            <thead class="bg-yellow-400 text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Activity</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Option</th>


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
                                    <td>
                                        <form id="deleteActivity" action="{{ route('record.destroy', $activity->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" id="deteleActivityButton">
                                                {{__('DELETE')}}
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                <!-- end table content -->
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            $('#activity-table').DataTable();
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