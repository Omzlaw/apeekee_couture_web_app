<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $casts = [
        'creator_id' => 'integer',
        'cost'       => 'float',
        'status'     => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
