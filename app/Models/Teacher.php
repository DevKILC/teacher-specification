<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    public function certifications()
{
    // Relasi tabel certifications dengan teachers
    return $this->hasMany(Certification::class, 'teacher_id', 'id');
}
    public function teacherAllSkills()
{
    return $this->hasMany(TeacherSkill::class, 'teacher_id', 'id');
}
}