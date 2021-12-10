<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = [
        "rate",
        "comment",
        "user_id",
        "item_id",
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
