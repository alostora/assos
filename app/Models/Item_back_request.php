<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_back_request extends Model
{
    use HasFactory;
    protected $table = "item_back_requests";
    protected $fillable = [
        'order_id',
        'order_item_id',
        'user_id',
        'status',//['waiting','accepted','refused']
        'item_back_count',
        'reason_id',
    ];
}
