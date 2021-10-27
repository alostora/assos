<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_image extends Model
{
    use HasFactory;
    protected $table = "item_images";
    protected $fillable = [
    	'itemImageName',
    	'item_id',
    ];
}
