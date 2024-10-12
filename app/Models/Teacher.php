<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';


    protected function imgUrl(): Attribute
    {
        return Attribute::get(function ($value) {
            if (str_contains($value, 'google')) {
                return $value;
            }
            if ($value) {
                return 'https://s3.ap-southeast-1.wasabisys.com/file-members.kampunginggris.id/' . $value;
            }
            if(!$value){
            return 'https://static.vecteezy.com/system/resources/thumbnails/001/840/618/small_2x/picture-profile-icon-male-icon-human-or-people-sign-and-symbol-free-vector.jpg';
            }
        });
    }

    public static function dummyData()
    {
        $dummyTeacher = new self(); // Membuat instance model Teacher
        $dummyTeacher->id ='0'; // ID dummy
        $dummyTeacher->name = 'Dummy Teacher'; // Nama dummy
        $dummyTeacher->address = '123 Dummy Address'; // Alamat dummy
        $dummyTeacher->phone = '0000000000'; // Nomor dummy

        // Menetapkan teacherSkills dummy

        return $dummyTeacher;
    }

    public function certifications()
    {
        // Relasi tabel certifications dengan teachers
        return $this->hasMany(Certification::class, 'teacher_id', 'id');
    }
    public function teacherSkills()
    {
        return $this->hasMany(TeacherSkill::class, 'teacher_id', 'id');
    }
    public function activity()
    {
        return $this->hasMany(Record::class, 'teacher_id', 'id');
    }
}