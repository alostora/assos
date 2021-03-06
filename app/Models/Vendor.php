<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Vendor extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'vendor_name',
        'email',       
        'phone',       
        'password',
        'vendor_image',
        'vendor_logo',
        'country',//[sa,kw]
        'address',
        'api_token',
        'firebase_token',
    ];

    protected $hidden = [
        'firebase_token',
        'api_token',
        'password'
    ];

}
