<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Sub_category;
use App\Models\Category;
use App\Models\Item;
use App\Models\User_fav_item;
use App\Models\User;
use URL;

class Users extends Controller
{
    

    public function vendors(){
        $data['status'] = true;
        $data['vendors'] = Vendor::get(['id','vendor_name','vendor_image']);

        if(!empty($data['vendors'])){
            foreach($data['vendors'] as $key => $vend){
                $vend->vendor_image = URL::to('Admin_uploads/vendors/'.$vend->vendor_image);
            }
        }
        return $data;
    }




    public function vendorCategories($vendor_id){
        $data['status'] = true;

        $data['categories'] = Category::with('sub_categories')->get();
        $vendor_sub_cats_id = Item::where('vendor_id',$vendor_id)->pluck('sub_cat_id');
        if(!empty($vendor_sub_cats_id)) {
            $vendor_cats_id = Sub_category::whereIn('id',$vendor_sub_cats_id)->pluck('cat_id');
            if(!empty($vendor_cats_id)) {
                $data['categories'] = Category::with('sub_categories')->whereIn('id',$vendor_cats_id)->get();
            }
        }

        if(!empty($data['categories'])) {
            foreach($data['categories'] as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
                if(count($cat->sub_categories)>0){
                    foreach($cat->sub_categories as $sub_cat){
                        $sub_cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$sub_cat->s_categoryImage);
                    }
                }
            }
        }
        return $data;
    }





    public function categories(){
        $data['status'] = true;
        $data['categories'] = Category::with('sub_categories')->get();
        
        if (!empty($data['categories'])) {
            foreach($data['categories'] as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
                if(count($cat->sub_categories)>0){
                    foreach($cat->sub_categories as $sub_cat){
                        $sub_cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$sub_cat->s_categoryImage);
                    }
                }
            }
        }
        return $data;
    }




    public function items(Request $request,$s_cat_id,$vendor_id=false){

        $deviceId = $request->header('device-id');
        $user = User::where('deviceId',$deviceId)->first();
        if (!empty($user)) {
            
            $data['status'] = true;
            if($vendor_id == false) {
                $data['items'] = Item::where('sub_cat_id',$s_cat_id)->select(['id','itemName','itemImage','itemPrice','itemPriceAfterDis'])->paginate(20);
            }else{
                $data['items'] = Item::where('sub_cat_id',$s_cat_id)->where('vendor_id',$vendor_id)->select(['id','itemName','itemImage','itemPrice','itemPriceAfterDis'])->paginate(20);
            }

            foreach($data['items'] as $item){
                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $item->fav = !empty($fav) ? true : false;
                $item->cart = false;
            }

        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }

        foreach($data['items'] as $itemImage){
            $itemImage->itemImage = URL::to('uploads/itemImages/'.$itemImage->itemImage);
            $itemImage->fav = false;
            $itemImage->cart = false;
        return $data;
    }





    public function itemInfo(Request $request,$itemId){

        $deviceId = $request->header('device-id');
        $user = User::where('deviceId',$deviceId)->first();
        if (!empty($user)) {
            
            $data['status'] = true;
            $data['item'] = Item::where('id',$itemId)
            ->with('other_item_images')
            ->with('item_prop_plus')
            ->first(['id','itemName','itemImage','itemPrice','itemPriceAfterDis']);


            foreach($data['item']->other_item_images as $otherImage){

                $otherImage->itemImageName = URL::to('uploads/itemImages/'.$otherImage->itemImageName);
            }


            $data['item']->itemImage = URL::to('uploads/itemImages/'.$data['item']->itemImage);
            
            $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$data['item']->id)->first();

            $data['item']->fav = !empty($fav) ? true : false;
            $data['item']->cart = false;

        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;

    }





    public function addItemToFav(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        if (!empty($user)) {
            $user_id = $user->id;
            $user_fav = User_fav_item::where(['item_id'=>$item_id,'user_id'=>$user_id])->first();
            if (empty($user_fav)) {
                User_fav_item::create([
                    'item_id'=>$item_id,
                    'user_id'=>$user_id
                ]);
            }

            $data['status'] = true;
            $data['message'] = 'item add to fav success';
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;

    }





    public function removeItemFromFav(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        if (!empty($user)) {
            $user_id = $user->id;
            User_fav_item::where('user_id',$user_id)->where('item_id',$item_id)->delete();

            $data['status'] = true;
            $data['message'] = 'item deleted from fav success';
        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;

    }





    public function userItemsFav(Request $request){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();
            
        if(!empty($user)) {
            $user_id = $user->id;
            $data['status'] = true;

            $fav_item_id = User_fav_item::where('user_id',$user_id)->get();
            $data['items'] = Item::whereIn('id',$fav_item_id)->get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis']);

            if(!empty($data['items'])){
                foreach($data['items'] as $item){
                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $item->fav = !empty($fav) ? true : false;
                    $item->cart = false;
                }
            }

        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;

    }






}
