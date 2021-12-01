<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'status',
        'total_price',
        'user_id'

    ];


    public function order_items(){
        return $this->hasMany('App\Models\Order_item','order_id');
    }
}
