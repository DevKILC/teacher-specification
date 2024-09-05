<div>
    <x-form-section submit="createSkill">
        <x-slot name="title">
            {{ __('Create Skill') }}
        </x-slot>
    
        <x-slot name="description">
            {{ __('Click the checkboxes if you want add new skill to this teacher {{ $teacherName }}') }}
        </x-slot>
    
        <x-slot name="form">
            <!-- Skill Name -->
            <div class="col-span-6 sm:col-span-4">
            @csrf
                <input type="hidden" name="teacher_id" value="{{ $teacherId }}">

                <label for="skillSelect" class="block mb-2 text-sm">Choose Skill Name</label>
                <div class="space-y-3">
                    @foreach($allSkills as $skill)
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="skill_{{ $skill->skill }}" wire:model.defer="selectedSkills"
                            value="{{ $skill->id_skill }}" @if(in_array($skill->id_skill, $teachersSkillsGetValidation)) disabled checked @endif>
                        <label for="skill_{{ $skill->id_skill }}">{{ $skill->name }}</label>
                    </div>
                    @endforeach
                </div>
                <x-input-error for="name" class="mt-2" />
            </div>
    
                <x-input-error for="type" class="mt-2" />
            </div>
        </x-slot>
    
        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Skill has been added successfully.') }}
            </x-action-message>
    
            <x-button>
                {{ __('Confirm Skill') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
