<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSkill extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'skill_id',
    ];
    protected $table = 'teacher_skills';

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id' , 'id');
    }
    public function skills()
    {
        return $this->belongsTo(Skill::class, 'skill_id' , 'id_skill');
    }
}