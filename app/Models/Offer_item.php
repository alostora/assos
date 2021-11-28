<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer_item extends Model
{
    use HasFactory;
    protected $table = "offer_items";
    protected $fillable = [
        "offer_id",
        "item_id",
    ];


    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
