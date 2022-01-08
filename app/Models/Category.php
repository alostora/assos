<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $fillable = [
        "categoryName",
        "categoryNameAr",
        "categoryImage",
        "categorySliderImage",
        "sliderHomeStatus",
        "sliderCategoryStatus",
    ];
    

    protected $hidden = [
        "categoryNameAr",
        'updated_at',
        'created_at'
    ];


    
    public function sub_categories(){
        return $this->hasMany('App\Models\Sub_category','cat_id');
    }





    public function items(){
        return $this->hasManyThrough(
            'App\Models\Item',
            'App\Models\Sub_category',
            'cat_id',
            'sub_cat_id',
            'id',
            'id'
        );
    }
}
