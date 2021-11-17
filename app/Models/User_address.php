<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{
    use HasFactory;
    protected $table = "user_addresses";
    protected $fillable = [
        'title',
        'address',
        'isMain',//[true,false]
        'user_id'
    ];
}
