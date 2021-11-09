<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_property_plus extends Model
{
    
    use HasFactory;
	protected $table = "item_property_pluses";
	protected $fillable = [
		'sub_prop_id',//main prop
		'properity_id',//main item prop
	];

	
    
    protected $hidden = [
        "propertyDetails",
    ];
}
