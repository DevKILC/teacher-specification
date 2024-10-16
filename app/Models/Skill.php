<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $table = 'skills';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'type',
    ];
    public function skills()
    {
        return $this->hasMany(TeacherSkill::class, 'id_skill','skill_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }
}
