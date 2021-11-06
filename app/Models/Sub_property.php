<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_property extends Model
{
    use HasFactory;
    protected $table = 'sub_properties';
    protected $fillable = [
        'propertyName',
        'propertyNameAr',
        'prop_id',
    ];
}
