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
use App\Models\Review;
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




    public function vendorCategories(Request $request,$vendor_id){
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
                $cat->categoryName = $request->header('accept-language') == 'en' ? $cat->categoryName : $cat->categoryNameAr;
                if(count($cat->sub_categories)>0){
                    foreach($cat->sub_categories as $sub_cat){
                        $sub_cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$sub_cat->s_categoryImage);
                        $sub_cat->categoryName = $request->header('accept-language') == 'en' ? $sub_cat->categoryName : $sub_cat->categoryNameAr;
                    }
                }
            }
        }
        return $data;
    }





    public function categories(Request $request){
        $data['status'] = true;
        $data['categories'] = Category::with('sub_categories')->get();
        
        if (!empty($data['categories'])) {
            foreach($data['categories'] as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
                $cat->categoryName = $request->header('accept-language') == 'en' ? $cat->categoryName : $cat->categoryNameAr;
                if(count($cat->sub_categories)>0){
                    foreach($cat->sub_categories as $sub_cat){
                        $sub_cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$sub_cat->s_categoryImage);
                        $sub_cat->categoryName = $request->header('accept-language') == 'en' ? $sub_cat->categoryName : $sub_cat->categoryNameAr;
                    }
                }
            }
        }
        return $data;
    }




    public function items(Request $request,$s_cat_id,$vendor_id=false){

        $deviceId = $request->header('device-id');
        $user = User::where('deviceId',$deviceId)->first();
        if (!empty($user)){
            
            $data['status'] = true;
            if($vendor_id == false) {
                $data['items'] = Item::where('sub_cat_id',$s_cat_id)->select(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->paginate(20);
            }else{
                $data['items'] = Item::where('sub_cat_id',$s_cat_id)->where('vendor_id',$vendor_id)->select(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->paginate(20);
            }

            if(!empty($data['items'])){
                foreach($data['items'] as $item){

                    $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;
                    $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

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





    public function itemInfo(Request $request,$itemId){

        $deviceId = $request->header('device-id');
        $user = User::where('deviceId',$deviceId)->first();
        if(!empty($user)){
            
            $data['status'] = true;

            $data['item'] = Item::where('id',$itemId)
            ->with('other_item_images')
            ->with(['reviews'=>function($query){
                $query->limit(3);
            }])
            ->with(['item_properities'=>function($query){
                $query->with('item_prop_plus');
            }])->first();

            $data['item']->itemName = $request->header('accept-language') == 'en' ? $data['item']->itemName : $data['item']->itemNameAr;

            $data['item']->itemDescribe = $request->header('accept-language') == 'en' ? $data['item']->itemDescribe : $data['item']->itemDescribeAr;

            if (!empty($data['item'])) {
                $data['item']->vendor_info = Vendor::find($data['item']->vendor_id);
                $data['item']->vendor_info->vendor_image = URL::to('Admin_uploads/vendors/'.$data['item']->vendor_info->vendor_image);

                if (count($data['item']->other_item_images)) {
                    foreach($data['item']->other_item_images as $otherImage){
                        $otherImage->itemImageName = URL::to('uploads/itemImages/'.$otherImage->itemImageName);
                            // code...
                    }
                }

                if (count($data['item']->reviews)) {
                    foreach($data['item']->reviews as $review){
                        $review->user_info = User::where('id',$review->user_id)->first(['id','name','image']);
                        $review->user_info->image = URL::to('Admin_uploads/vendors/'.$review->user_info->image);
                    }
                }

                $data['item']->itemImage = URL::to('uploads/itemImages/'.$data['item']->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$data['item']->id)->first();

                $data['item']->itemMayLike = Item::limit(10)->get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

                if (!empty($data['item']->itemMayLike)) {
                    foreach($data['item']->itemMayLike as $itemMayLike){
                        $itemMayLike->itemName = $request->header('accept-language') == 'en' ? $itemMayLike->itemName : $itemMayLike->itemNameAr;

                        $itemMayLike->itemImage = URL::to('uploads/itemImages/'.$itemMayLike->itemImage);
                        $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$itemMayLike->id)->first();
                        $itemMayLike->fav = !empty($fav) ? true : false;
                        $itemMayLike->cart = false;
                    }
                }

                $data['item']->itemFit = Item::limit(10)->get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

                if (!empty($data['item']->itemFit)) {
                    foreach($data['item']->itemFit as $itemFit){
                        $itemFit->itemName = $request->header('accept-language') == 'en' ? $itemFit->itemName : $itemFit->itemNameAr;

                        $itemFit->itemImage = URL::to('uploads/itemImages/'.$itemFit->itemImage);
                        $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$itemFit->id)->first();
                        $itemFit->fav = !empty($fav) ? true : false;
                        $itemFit->cart = false;
                    }
                }


                $data['item']->fav = !empty($fav) ? true : false;
                $data['item']->cart = false;
            }


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
            if(!empty(Item::find($item_id))){
                if (empty($user_fav)) {
                    User_fav_item::create([
                        'item_id'=>$item_id,
                        'user_id'=>$user_id
                    ]);
                }
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
                    $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;

                    $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribe;
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





    public function userItemReview(Request $request){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();
        $item = Item::find($request->item_id);
            
        if(!empty($user)) {
            $user_id = $user->id;
            $item = Item::find($request->item_id);
            if(!empty($item)) {
                $data['status'] = true;
                $data['message'] = 'review add';
                Review::create([
                    'rate'=>$request->rate,
                    'comment'=>$request->comment,
                    'user_id'=>$user->id,
                    'item_id'=>$item->id,
                ]);
            }else{
                $data['status'] = false;
                $data['message'] = 'item not found';
            }

        }else{
            $data['status'] = false;
            $data['message'] = 'user not found';
        }
        return $data;
    }







    public function itemReviews(Request $request,$item_id){


        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        $data['status'] = true;
        $data['reviews'] = Review::where('item_id',$item_id)->get();

        if(!empty($data['reviews'])){
            foreach($data['reviews'] as $review){
                $review->user_info = User::where('id',$review->user_id)->first(['id','name','image']);
                $review->user_info->image = URL::to('Admin_uploads/vendors/'.$review->user_info->image);
            }  
        }

        return $data;

    }




    //still only example
    public function itemMayLike(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        
        $data['status'] = true;
        $data['items'] = Item::/*where('id',$item_id)->*/get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue']);


        if(!empty($data['items'])){
            foreach($data['items'] as $item){
                $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;

                $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribeAr;
                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $item->fav = !empty($fav) ? true : false;
                $item->cart = false;
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'item not found';
        }

        return $data;

    }





    public function itemFit(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        $data['status'] = true;
        $data['items'] = Item::/*where('id',$item_id)->*/get(['id','itemName','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

        if(!empty($data['items'])){
            foreach($data['items'] as $item){
                $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;
                $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribeAr;
                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $item->fav = !empty($fav) ? true : false;
                $item->cart = false;
            }
        }else{
            $data['status'] = false;
            $data['message'] = 'item not found';
        }

        return $data;
    }




    public function itemSearch(Request $request){


        $device_id = $request->header('device-id');
        $user = User::where('deviceId',$device_id)->first();

        if (!empty($user)) {
            // code...
            $data['status'] = true;
            if (!empty($request->itemNameSearch)) {
                $data['items'] = Item::where('itemNAme','like',"%".$request->itemNameSearch."%")
                ->orWhere('itemNAmeAr','like',"%".$request->itemNameSearch."%")
                ->paginate(20);
            }else{
                $data['items'] = Item::paginate(20);
            }

            if(!empty($data['items'])){
                foreach($data['items'] as $item){

                    $item->itemName = $request->header('accept-language') == 'en' ? $item->itemName : $item->itemNameAr;
                    $item->itemDescribe = $request->header('accept-language') == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

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
