<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = "items";
    protected $fillable = [
        "itemName",
        "itemNameAr",
        "itemDesc",
        "itemDescAr",
        "itemImage",
        "itemPrice",
        "dicountPrice",
        "s_cat_id",
    ];


    
}
