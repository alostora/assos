<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    use HasFactory;
    protected $table = "privacies";
    protected $fillable = [

        "privacyTitle",
        "privacyTitleAr",
        "privacy",
        "privacyAr",
        "type",
    ];

    protected $hidden = [
        "privacyTitleAr",
        "privacyAr",
        "created_at",
        "updated_at",
    ];
}
