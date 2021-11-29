<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item_prop extends Model
{
    use HasFactory;
    protected $table = 'order_item_props';
     protected $fillable = [
        'order_item_id',
        'item_prop_id',
    ];
}
