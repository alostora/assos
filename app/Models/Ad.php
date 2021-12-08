<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $table="ads";
    protected $fillable = [
        'adImage',
        'vendor_id',
        'cat_id',
    ];

    protected $hidden = [
        "updated_at",
        "created_at",
    ];
}
