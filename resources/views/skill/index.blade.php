<x-app-layout>
    <x-slot name="header">
        <div x-data="{ open: false }">

            <!-- Header Title -->
            <h2 class="font-medium  text-2xl text-gray-800 leading-tight">
                {{ __('Skill & Category') }}
            </h2>
            
        </div>
    </x-slot>

    <div x-data="{ openSkillModal: false, openCategoryModal: false }">
        

        {{-- SKILLS --}}
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end py-10">
                <x-button @click="openSkillModal = true">
                    {{ __('Add Skill') }}
                </x-button>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Teacher List -->
                @if($skills->isEmpty())
                    <p>No skills available.</p>
                @else
                    <table class="table-auto" id="skills-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skills as $skill)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $skill->name }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('teacher.show', $skill->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">View</a>
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
                <!-- Teacher List -->
                @if($categories->isEmpty())
                    <p>No Category available.</p>
                @else
                    <table class="table-auto" id="categories-table">
                        <thead>
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
                                    <td class="border px-4 py-2">
                                        {{-- <a href="{{ route('category.show', $category->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">View</a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        
        {{-- Skill Modal --}}
        <x-general.modal :open="'openSkillModal'" :title="__('Create Skill')">
            <x-general.form-section :submit="route('skill.store')">
                <!-- Form fields slot -->
                <x-slot name="form">
                    <!-- Skill Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Skill Name') }}" />
                        <x-input id="skillName" type="text" name="name" value="{{ old('name') }}" required />
                        <x-input-error for="name" class="mt-2" />
                    </div>
        
                    <!-- Skill Description -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="description" value="{{ __('Skill Description') }}" />
                        <x-textarea id="skillDescription" name="description" rows="3">{{ old('description') }}</x-textarea>
                        <x-input-error for="description" class="mt-2" />
                    </div>
        
                    <!-- Skill Category -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="category_id" value="{{ __('Skill Category') }}" />
                        <x-select id="skillCategory" name="category_id" required>
                            <option value="">{{ __('Select a category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error for="category_id" class="mt-2" />
                    </div>
        
                    <!-- Skill Type -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="type" value="{{ __('Type') }}" />
                        <x-select id="type" name="type" required>
                            <option value="">{{ __('Select Type') }}</option>
                            <option value="ONLINE" {{ old('type') == 'ONLINE' ? 'selected' : '' }}>{{ __('Online') }}</option>
                            <option value="OFFLINE" {{ old('type') == 'OFFLINE' ? 'selected' : '' }}>{{ __('Offline') }}</option>
                        </x-select>
                        <x-input-error for="type" class="mt-2" />
                    </div>
                </x-slot>
        
                <!-- Actions slot (optional) -->
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

        {{-- Modal  --}}
        <x-general.modal :open="'openCategoryModal'" :title="__('Create Category')">
            <x-general.form-section :submit="route('category.store')">
                <!-- Form fields slot -->
                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Category Name') }}" />
                        <x-input id="CategoryName" type="text" name="name" value="{{ old('name') }}" />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                </x-slot>
            
                <!-- Actions slot (optional) -->
                <x-slot name="actions">
                    <x-button class="bg-blue-500 text-white hover:bg-blue-600">
                        {{ __('Save') }}
                    </x-button>
                    <x-button type="button" class="ml-4">
                        {{ __('Cancel') }}
                    </x-button>
                </x-slot>
            </x-general.form-section>
        </x-general.modal>

        
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#skills-table').DataTable();
                $('#categories-table').DataTable();
            });

            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    text: '{{ Session::get('success') }}',
                    toast: true,
                    position: 'top-end',  // Position of the toast (e.g., top-end, bottom-end)
                    showConfirmButton: false,
                    timer: 2000,  // Toast will automatically disappear after 2 seconds
                    timerProgressBar: true
                });
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    text: '{{ Session::get('error') }}',
                    toast: true,
                    position: 'top-end',  // Position of the toast (e.g., top-end, bottom-end)
                    showConfirmButton: false,
                    timer: 2000,  // Toast will automatically disappear after 2 seconds
                    timerProgressBar: true
                });
            @endif
        </script>
    @endpush
</x-app-layout>