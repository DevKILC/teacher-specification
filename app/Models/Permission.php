<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';

    public function requests()
    {   
    return $this->belongsTo(RequestPermission::class, 'id', 'permission_id');
    }

    // foreign ke model_has_permission
    public function modelHasPermissions()
    {
        return $this->hasMany(ModelHasPermission::class, 'permission_id', 'id');
    }
    

}
