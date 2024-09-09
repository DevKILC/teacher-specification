<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;
    protected $table = 'activities';

    protected $fillable = [
        'teacher_id',
        'category_id',
        'activity',
        'date'];
        public function teachers()
        {
            return $this->belongsTo(Teacher::class, 'teacher_id' , 'id');
        }
        public function category()
        {
            return $this->belongsTo(CategoryActivity::class, 'category_id');
        }
        
    }

