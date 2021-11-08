<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_properity extends Model
{
    use HasFactory;
 	protected $table = "item_properities";
    protected $fillable = [
    	'main_prop_id',//one to one
    	'item_id',
    ];




    
    public function item_prop_plus(){
        return $this->hasMany('App\Models\Item_property_plus','properity_id');
    }




}
