<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_name',
        'phone',       
        'email',       
        'vendor_image',
        'address',
        'password',
        'api_token',
        'firebase_token',
    ];
    protected $hidden = ['password'];

}
