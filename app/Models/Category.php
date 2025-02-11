<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';
    protected $dates = ['deleted_at']; 

    protected $fillable = [
        'name',
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class, 'category_id');
    }
}
