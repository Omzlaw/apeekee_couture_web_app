<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $casts = [
        'parent_id'  => 'integer',
        'position'   => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function childes()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
