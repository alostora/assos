<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{
    use HasFactory;
    protected $table = "user_addresses";
    protected $fillable = [
        
        'name',
        'phone',
        'street',
        'address',
        'addressDESC',
        'homeNumber',
        'postalCode',
        'lng',
        'lat',
        'isMain',//[true,false]
        'user_id'
    ];
}
