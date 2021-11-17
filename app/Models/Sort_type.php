<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sort_type extends Model
{
    use HasFactory;
    protected $table = 'sort_types';
    protected $fillable = [
        'sortTypeName',
        'sortTypeNameAr',
        'sortKeyName',
    ];

    protected $hidden = [
        'sortTypeNameAr'
    ];
}
