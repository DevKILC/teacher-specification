
<x-form-section submit="createCategory">
    <x-slot name="title">
        {{ __('Create Category') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Fill in the details below to create a new skill with its category.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Category Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Category Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Category created successfully.') }}
        </x-action-message>

        <x-button>
            {{ __('Create Category') }}
        </x-button>
    </x-slot>
</x-form-section>