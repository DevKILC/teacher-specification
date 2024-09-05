<?php

namespace App\Livewire\Teacher;
use Livewire\Component;
use App\Models\Teacher;
use App\Models\Skill;
use App\Models\TeacherSkill;
use Illuminate\Support\Facades\DB;


class Addskill extends Component
{   
    
        public $teacher;
        public $allTeachers;
        public $allSkills;
        public $teachersSkillsGetValidation = [];
        public $selectedSkills = [];
        public $teacherId;
        public $isOpen = false;
    
        public function mount($teacherId = null)
        {
            $this->teacherId = $teacherId;
            $this->allTeachers = Teacher::all();
            $this->allSkills = Skill::all();
    
            // Load teacher and associated skills if teacherId is provided
            if ($teacherId) {
                $this->teacher = Teacher::with('teacherskills.skills')->find($teacherId);
                $this->teachersSkillsGetValidation = $this->teacher->teacherSkills->pluck('skills.skill_id')->toArray();
            }
        }
    
        public function addSelectedSkills($value)
        {
            $this->selectedSkills = $value;
        }
    
        public function saveSkills()
        {
            $this->validate([
                'teacherId' => 'required|exists:teachers,id',
                'selectedSkills' => 'required|array',
                'selectedSkills.*' => 'exists:skills,id_skill',
            ]);
    
         
                $data = [];
                foreach ($this->selectedSkills as $skillId) {
                    $data[] = [
                        'teacher_id' => $this->teacherId,
                        'skill_id' => $skillId,
                    ];
                }
    
                DB::table('teacher_skills')->insert($data);
    
                $this->redirect('/teacher');
             
        }
    
    
    public function render()
    {
        return view('livewire.teacher.addskill');
    }
}