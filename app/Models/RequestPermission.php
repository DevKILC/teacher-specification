<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'permission_id',
        'stats',
        'created_by'];
    protected $table = 'request_permission';

    public function permissions()
    {   
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }
    public function user()
    {
        return $this->hasOne(UserManagement::class, 'id', 'user_id');
    }
}
