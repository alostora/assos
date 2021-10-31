<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = "items";
    protected $fillable = [

        "facePage",
        "videoLink",
        "itemName",
        "itemNameAr",
        "itemDescribe",
        "itemDescribeAr",
        "itemImage",
        "itemPrice",
        "itemPriceAfterDis",
        //"itemMainPrice",
        "discountType",//[percent,without]
        "discountValue",
        "itemCount",
        "sallesAppear",//[yes,no]
        "publicAppear",//[yes,no]
        "viewInBanner",//[yes,no]
        "bannerType",//[1,2,3,4]
        //"bannerImage",
        "withProp",//[hasProperty,dontHasProperty]
        "rate",
        "sub_cat_id",
        "vendor_id",
    ];

    protected $hidden = [
        'facePage',
        'discountType',
        'sallesAppear',
        'publicAppear',
        'viewInBanner',
        'bannerType',
        'withProp',
        "itemNameAr",
    ];








    public function item_properities(){
        return $this->hasMany('App\Models\Item_properity','item_id');
    }

    public function item_prop_plus(){
        return $this->hasManyThrough('App\Models\Item_property_plus','App\Models\Item_properity','item_id','properity_id','id','id');
    }

    public function other_item_images(){
        return $this->hasMany('App\Models\Item_image','item_id');
    }


    public function cart_items(){
        return $this->hasMany('App\Models\Cart_item','item_id');
    }

    public function fav_items(){
         return $this->hasMany('App\Models\User_fav_item','item_id');
    }

    public function item_rate_comment(){
         return $this->hasMany('App\Models\User_item_rate_comment','item_id');
    }



    
}
