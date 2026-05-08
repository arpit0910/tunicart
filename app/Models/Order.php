<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_amount', 'status', 'shipping_address', 'phone', 
        'city', 'pincode', 'payment_method', 'payment_status', 'transaction_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
