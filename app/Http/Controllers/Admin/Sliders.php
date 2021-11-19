<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class Sliders extends Controller
{
    

    public function sliderInfo($type){
        $data['categories'] = Category::get();
        $data['items'] = Item::get();
        return view('Admin/Sliders/sliderInfo',$data);
    }




    public function changeCatSliderStatus($cat_id,$type){
        $category = Category::find($cat_id);
        if (!empty($category)) {
            if($type == 'home'){
                $category->update(['sliderHomeStatus' => !$category->sliderHomeStatus]);
            }elseif($type == 'category') {
                $category->update(['sliderCategoryStatus'=> !$category->sliderCategoryStatus]);
            }
        }

        session()->flash('success','done');
        return back();
    }





    public function changeItemSliderStatus($item_id,$type){
        $item = Item::find($item_id);
        if (!empty($item)) {
            if($type == 'home'){
                $item->update(['sliderHomeStatus' => !$item->sliderHomeStatus]);
            }elseif ($type == 'category') {
                $item->update(['sliderCategoryStatus'=>!$item->sliderCategoryStatus]);
            }
        }

        session()->flash('success','done');
        return back();
    }




}
