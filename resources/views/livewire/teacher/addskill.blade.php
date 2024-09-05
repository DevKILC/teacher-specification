<div>
    <!-- Modal Trigger Button -->
    <button wire:click="$set('isOpen', true)" class="w-[150px] lg:w-[180px] h-[40px] lg:h-[50px] bg-yellow-400 hover:bg-yellow-500 rounded-md text-white">+ Add New Skill</button>

    <!-- Modal Component -->
    <x-modal id="addSkillModal" maxWidth="2xl">
        <div class="modal-header flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Add Skill</h2>
            <button wire:click="$set('isOpen', false)" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>

        <div class="modal-body">
            <form wire:submit.prevent="saveSkills">
                @csrf
                <input type="hidden" name="teacher_id" value="{{ $teacherId }}">

                <label for="skillSelect" class="block mb-2 text-sm">Choose Skill Name</label>
                <div class="space-y-3">
                    @foreach($allSkills as $skill)
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="skill_{{ $skill->skill }}" wire:model="selectedSkills"
                            value="{{ $skill->id_skill }}" @if(in_array($skill->id_skill, $teachersSkillsGetValidation)) disabled checked @endif>
                        <label for="skill_{{ $skill->id_skill }}">{{ $skill->name_skill }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 flex justify-end space-x-3">
                    <button type="button" wire:click="$set('isOpen', false)"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md">Close</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Confirm Skill</button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
