<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;
    protected $table = 'certifications';
    protected $fillable = [
        'teacher_id',  // Foreign Key
        'name',
    ];

    public function certifications()
    {   
    return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}
