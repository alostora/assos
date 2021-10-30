<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_fav_item extends Model
{
    use HasFactory;
    protected $table = 'user_fav_items';
    protected $fillable = [
        'user_id',
        'item_id',
    ];
}
