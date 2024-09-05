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
        <div x-show="openSkillModal" @click.away="openSkillModal = false" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ __('Create Skill') }}
                    </h2>
                    <button @click="openSkillModal = false" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 96 960 960" width="24" fill="black">
                            <path d="M720 936 528 744 336 936l-72-72 192-192-192-192 72-72 192 192 192-192 72 72-192 192 192 192-72 72Z"/>
                        </svg>
                    </button>
                </div>
    
                <!-- Modal Body -->
                <form method="POST" action="{{ route('skill.store') }}">
                    @csrf
    
                    <!-- Skill Name -->
                    <div class="mb-4">
                        <label for="skillName" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Skill Name') }}
                        </label>
                        <input type="text" id="skillName" name="name" required
                               class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
    
                    <!-- Skill Description -->
                    <div class="mb-4">
                        <label for="skillDescription" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Skill Description') }}
                        </label>
                        <textarea id="skillDescription" name="description" rows="3"
                                  class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>
    
                    <!-- Skill Category -->
                    <div class="mb-4">
                        <label for="skillCategory" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Skill Category') }}
                        </label>
                        <select id="skillCategory" name="category_id" required
                                class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="type" value="{{ __('Type') }}" />
                            <select id="type" class="mt-1 block w-full form-select" name="type">
                                <option value="">{{ __('Select Type') }}</option>
                                <option value="OFFLINE">{{ __('Online') }}</option>
                                <option value="ONLINE">{{ __('Offline') }}</option>
                            </select>
                            <x-input-error for="type" class="mt-2" />
                        </div>
                    </div>
    
                    <!-- Submit Button -->
                    <div class="flex items-center justify-end">
                        <x-button type="submit" class="bg-blue-500 text-white hover:bg-blue-600">
                            {{ __('Save') }}
                        </x-button>
                        <x-button @click="openSkillModal = false" class="ml-4">
                            {{ __('Cancel') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal  --}}
        <div x-show="openCategoryModal" @click.away="openCategoryModal = false" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ __('Create Category') }}
                    </h2>
                    <button @click="oepnCategoryModal = false" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 96 960 960" width="24" fill="black">
                            <path d="M720 936 528 744 336 936l-72-72 192-192-192-192 72-72 192 192 192-192 72 72-192 192 192 192-72 72Z"/>
                        </svg>
                    </button>
                </div>
    
                <!-- Modal Body -->
                <form method="POST" action="{{ route('category.store') }}">
                    @csrf
    
                    <!-- Skill Name -->
                    <div class="mb-4">
                        <label for="skillName" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Skill Name') }}
                        </label>
                        <input type="text" id="skillName" name="name" required
                               class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
    
                    <!-- Skill Description -->
                    <div class="mb-4">
                        <label for="skillDescription" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Skill Description') }}
                        </label>
                        <textarea id="skillDescription" name="description" rows="3"
                                  class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>
    
                    <!-- Skill Category -->
                    <div class="mb-4">
                        <label for="skillCategory" class="block text-gray-700 text-sm font-bold mb-2">
                            {{ __('Skill Category') }}
                        </label>
                        <select id="skillCategory" name="category_id" required
                                class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="type" value="{{ __('Type') }}" />
                            <select id="type" class="mt-1 block w-full form-select" name="type">
                                <option value="">{{ __('Select Type') }}</option>
                                <option value="OFFLINE">{{ __('Online') }}</option>
                                <option value="ONLINE">{{ __('Offline') }}</option>
                            </select>
                            <x-input-error for="type" class="mt-2" />
                        </div>
                    </div>
    
                    <!-- Submit Button -->
                    <div class="flex items-center justify-end">
                        <x-button type="submit" class="bg-blue-500 text-white hover:bg-blue-600">
                            {{ __('Save') }}
                        </x-button>
                        <x-button @click="oepnCategoryModal = false" class="ml-4">
                            {{ __('Cancel') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
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
                    title: 'Berhasil',
                    text: '{{ Session::get('success') }}',
                });
            @endif

            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ Session::get('error') }}',
                });
            @endif
        </script>
    @endpush
</x-app-layout>