<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    protected $table = 'activity_categories';
    public function activity()
    {
        return $this->belongsTo(Record::class, 'category_id');
    }
}
