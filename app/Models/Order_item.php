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
        'itemPrice'//itemPrice for one item
    ];


    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function order_items_props(){
        return $this->hasMany('App\Models\Order_item_prop','order_item_id');
    }
}
