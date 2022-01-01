<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_back_reason extends Model
{
    use HasFactory;
    protected $table = "item_back_reasons";
    protected $fillable = [
        "backReasonName",
        "backReasonArName",
    ];


    protected $hidden = [
        "backReasonArName"
    ];
}
