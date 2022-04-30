<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifii extends Model
{
    use HasFactory;


    protected $table = "notifiis";
    protected $fillable = [
        'title',
        'body',
        'read',//boolean
        'type',//[order,product,user]
        'type_id',//[order_id,product_id,user_id]
        'user_id',
        'delivery_id',
    ];


}
