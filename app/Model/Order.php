<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'order_amount' => 'float',
        'discount_amount' => 'float',
        'customer_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class)->orderBy('seller_id', 'ASC');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function sellerName()
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shipping()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address');
    }

}
