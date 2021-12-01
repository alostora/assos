<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
    protected $table = 'order_items';
    protected $fillable = [
        'item_count',
        'order_id',
        'item_id',
    ];


    public function order_items_props(){
        return $this->hasMany('App\Models\Order_item_prop','order_item_id');
    }
}
