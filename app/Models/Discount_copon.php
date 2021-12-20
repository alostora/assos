<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount_copon extends Model
{
    use HasFactory;
    protected $table = 'discount_copons';
    protected $fillable = [

        'code',
        'dateFrom',
        'dateTo',
        'discountValue',
        'vendor_id'
    ];

}
