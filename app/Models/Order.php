<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'status',//['new','confirmed']
        'shippingType',//[freeShipping,normalShipping,fastShipping]
        'paymentMethod',//[myFatora,cashOnDelivery]
        'total_price',
        'discountCopon',
        'addedTax',
        'shippingAddress_id',
        'user_id'
    ];

    protected $casts = [
        'total_price' => 'double',
        'discountCopon' => 'double',
    ];


    public function order_items(){
        return $this->hasMany('App\Models\Order_item','order_id');
    }
}
