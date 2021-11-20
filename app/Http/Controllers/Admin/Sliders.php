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
        if($type == 'home'){
            return view('Admin/Sliders/sliderHomeInfo',$data);
        }else{
            return view('Admin/Sliders/sliderCategoryInfo',$data);
        }
    }




    public function changeCatSliderStatus($cat_id,$type){
        $category = Category::find($cat_id);
        if (!empty($category)) {
            if($type == 'home'){
                $category->sliderHomeStatus = !$category->sliderHomeStatus;
            }elseif($type == 'category') {
                $category->sliderCategoryStatus = !$category->sliderCategoryStatus;
            }
            $category->save();
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
