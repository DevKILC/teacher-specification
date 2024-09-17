<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'permission_id',
    ];
    protected $table = 'model_has_permissions';
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
    // relasi dari usermanagement
    public function userManagement()
    {
        return $this->belongsTo(UserManagement::class, 'model_id');
    }
    public function model()
    {
        return $this->morphTo();
    }

}
