<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Delivery extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = "deliveries";
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'password',
        'image',
        'api_token',
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'verify_token',
        'updated_at',
        'created_at',
        'deviceId',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function deliveries(){
        return $this->hasMany('App\Models\Delivery','delivery_id');
    }
}

