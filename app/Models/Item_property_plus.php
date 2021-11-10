<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_property_plus extends Model
{
    
    use HasFactory;
	protected $table = "item_property_pluses";
	protected $fillable = [
		'properity_id',//main item prop
		'sub_prop_id',//main prop
	];

	
    
    protected $hidden = [
        /*"sub_prop_id",
        "properity_id",*/
        'created_at',
        'updated_at',
    ];
}
