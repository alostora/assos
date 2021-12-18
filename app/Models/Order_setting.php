<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_setting extends Model
{
    use HasFactory;
    protected $table = "order_settings";
    protected $fillable = [
        "settingName",
        "settingNameAr",
        "settingValue",
        "settingOptions",
        "settingOptionsAr",
    ];


    protected $hidden = [
        'settingNameAr',
        'settingOptionsAr',
    ];

    
    protected $casts = [
        'settingValue' => 'double',
    ];

}
