<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $table = 'skills';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'type',
    ];
    public function skills()
    {
        return $this->hasMany(TeacherSkill::class, 'skill_id' , 'id_skill');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
