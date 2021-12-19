<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_discount_copon extends Model
{
    use HasFactory;

    protected $table = 'user_discount_copons';
    protected $fillable = [
        'copon_id',
        'user_id',
    ];
}
