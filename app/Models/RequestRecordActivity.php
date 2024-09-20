<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRecordActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'activity_id',
        'category_id',
        'activity',
        'date',
        'stats',
        'user_id', // id user yang meminta record
        'created_by'

    ];
    protected $table = 'request_record_activities';


    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
    //    ambil data dari usermanagement
    public function user()
    {
        return $this->hasOne(UserManagement::class, 'id', 'user_id');
    }
    // ambil data dari CategoryActivity
    public function category_activity()
    {
        return $this->hasOne(CategoryActivity::class, 'id', 'category_id');
    }
}
