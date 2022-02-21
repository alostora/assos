<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class S_condition extends Model
{
    use HasFactory;

    protected $table = 's_conditions';
    protected $fillable = [
        'shippingConditions',
        'shippingConditionsAr',
        'image',
    ];

    protected $hidden = [
        'shippingConditionsAr',
    ];

}
