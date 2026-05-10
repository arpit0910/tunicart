<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'price', 'variant_details', 
        'front_image', 'back_image', 'front_placement', 'back_placement', 'customization_notes'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
