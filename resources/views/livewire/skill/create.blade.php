<div>
    <x-form-section submit="createSkill">
        <x-slot name="title">
            {{ __('Create Skill') }}
        </x-slot>
    
        <x-slot name="description">
            {{ __('Fill in the details below to create a new skill with its category.') }}
        </x-slot>
    
        <x-slot name="form">
            <!-- Skill Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Skill Name') }}" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" />
                <x-input-error for="name" class="mt-2" />
            </div>
    
            <!-- Skill Description -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="description" value="{{ __('Skill Description') }}" />
                <x-textarea id="description" class="mt-1 block w-full" wire:model.defer="description" />
                <x-input-error for="description" class="mt-2" />
            </div>
    
            <!-- Skill Category -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="category" value="{{ __('Skill Category') }}" />
                <select id="category" class="mt-1 block w-full form-select" wire:model.defer="category">
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <x-input-error for="category_id" class="mt-2" />
            </div>

            <!-- Type -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="type" value="{{ __('Type') }}" />
                <select id="type" class="mt-1 block w-full form-select" wire:model.defer="type">
                    <option value="">{{ __('Select Type') }}</option>
                    <option value="OFFLINE">{{ __('Online') }}</option>
                    <option value="ONLINE">{{ __('Offline') }}</option>
                </select>
                <x-input-error for="type" class="mt-2" />
            </div>
        </x-slot>
    
        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Skill created successfully.') }}
            </x-action-message>
    
            <x-button>
                {{ __('Create Skill') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>