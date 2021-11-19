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

        "itemSliderImage",
        "sliderHomeStatus",//[true,false]
        "sliderCategoryStatus",//[true,false]

        "itemPrice",
        "itemPriceAfterDis",
        "discountType",//[percent,without]
        "discountValue",
        "itemCount",
        "withProp",//[hasProperty,dontHasProperty]
        "rate",//average rate
        "sub_cat_id",
        "department",
        "main_prop_type",
        "vendor_id",
       
    ];

    protected $hidden = [
        'facePage',
        'discountType',
        'viewInBanner',
        'bannerType',
        'withProp',
        "itemNameAr",
        "itemDescribeAr",
    ];

    protected $cast = [
        'itemPrice' => 'integer',
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

    public function reviews(){
        return $this->hasMany('App\Models\Review','item_id');
    }



    
}
