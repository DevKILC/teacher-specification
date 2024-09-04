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
        
        {{-- Modal  --}}
        <div x-show="openSkillModal" @click.away="openSkillModal = false" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-xl font-semibold mb-4">{{ __('Create Skill') }}</h2>
                <form id="create-skill-form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Name Skill') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full"/>
                        <x-input-error for="name" class="mt-2" />
                    </div> 
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Name Category') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full"/>
                        <x-input-error for="name" class="mt-2" />
                    </div> 
                    <div class="flex flex-row justify-end gap-5 py-5">
                        <x-button>
                            {{ __('Create Skill') }}
                        </x-button>
                        <x-button @click="openSkillModal = false">
                            {{ __('Close') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal  --}}
        <div x-show="openCategoryModal" @click.away="openCategoryModal = false" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 class="text-xl font-semibold mb-4">{{ __('Create Category') }}</h2>
                <form id="create-category-form" action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Name Category') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full"/>
                        <x-input-error for="name" class="mt-2" />
                    </div> 
                    <div class="flex flex-row justify-end gap-5 py-5">
                        <x-button>
                            {{ __('Create Category') }}
                        </x-button>
                        <x-button @click="openCategoryModal = false">
                            {{ __('Close') }}
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
    </script>
    @endpush
</x-app-layout>