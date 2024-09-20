<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManagement extends Model
{
    use HasFactory;
    protected $table = 'users';

    // relasi ke RequestPermission
    public function requestPermissions()
    {
        return $this->belongsTo(RequestPermission::class, 'id', 'user_id');
    }
    // relasi ke RequestRecordActivity
    public function requestRecordActivities()
    {
        return $this->belongsTo(RequestRecordActivity::class, 'id', 'user_id');
    }
    // relasi user_id ke model_has_permission
    public function userPermissions()
    {
        return $this->hasMany(ModelHasPermission::class, 'user_id', 'id');
    }
   
}
