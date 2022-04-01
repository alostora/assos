<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'orderCode',
        'status',//['new','confirmed','delivey_accept']
        'shippingType',//[freeShipping,normalShipping,fastShipping]
        'paymentMethod',//[myFatora,cashOnDelivery]
        'total_price',
        'discountCopon',
        'addedTax',
        'sub_total',
        'total',
        'shippingValue',
        'shippingAddress_id',
        'user_id',
        'delivery_id'
    ];

    protected $casts = [
        'total_price' => 'double',
        'discountCopon' => 'double',
    ];


    public function order_items(){
        return $this->hasMany('App\Models\Order_item','order_id');
    }
}
