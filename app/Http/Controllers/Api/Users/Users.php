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
use App\Models\Item_property_plus;
use App\Models\Item_properity;
use App\Models\Property;
use App\Models\Sub_property;
use App\Models\Sort_type;
use App\Models\Offer;
use App\Models\Offer_item;
use App\Models\Ad;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Order_item_prop;
use App\Models\Privacy;
use App\Models\S_condition;
use App\Models\Notifii;
use App\Helpers\Helper;
use URL;
use Auth;
use Lang;
use Carbon\Carbon;


class Users extends Controller
{




    public function vendors(Request $request){
        $data['status'] = true;

        $main_filter = $request->header('main-filter');
        $country = $request->header('country');

        $vendorMainFIlter = Item::where([
            'department' => $main_filter,
            'country' => $country
        ])->pluck('vendor_id');

        $vendorMainFIlter =  array_unique($vendorMainFIlter->toArray());


        $data['vendors'] = !empty($vendorMainFIlter) ? Vendor::whereIn('id',$vendorMainFIlter)->get(['id','vendor_name','vendor_image','vendor_logo']) : [];

        if(!empty($data['vendors'])){
            foreach($data['vendors'] as $key => $vend){
                $vend->vendor_image = URL::to('Admin_uploads/vendors/'.$vend->vendor_image);
                $vend->vendor_logo = URL::to('Admin_uploads/vendors/'.$vend->vendor_logo);
            }
        }

        return $data;
    }




    public function vendorCategories(Request $request,$vendor_id){
        
        $data['status'] = true;
        $lang = $request->header('accept-language');
        $main_filter = $request->header('main-filter');
        $country = $request->header('country');

        $vendor_sub_cats_id = Item::where([
            'vendor_id' => $vendor_id,
            'department' => $main_filter,
            'country' => $country
        ])->pluck('sub_cat_id');

        if(!empty($vendor_sub_cats_id)){
            $vendor_sub_cats_id = array_unique($vendor_sub_cats_id->toArray());
            $vendor_cats_id = Sub_category::whereIn('id',$vendor_sub_cats_id)->pluck('cat_id');
            if(!empty($vendor_cats_id)) {
                $vendor_cats_id =  array_unique($vendor_cats_id->toArray());
                $categories = Category::whereIn('id',$vendor_cats_id)->get(['id','categoryName','categoryNameAr','categoryImage','sliderCategoryStatus','categorySliderImage']);
            }
        }

        if(!empty($categories)) {
            $sliders = [];
            foreach($categories as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
                $cat->categorySliderImage = URL::to('Admin_uploads/categories/'.$cat->categorySliderImage);
                $cat->categoryName = $lang == 'en' ? $cat->categoryName : $cat->categoryNameAr;

                if($cat->sliderCategoryStatus) {
                    $slider['id'] = $cat->id;
                    $slider['name'] = $cat->categoryName;
                    $slider['image'] = $cat->categorySliderImage;
                    $slider['type'] = 'category';
                    array_push($sliders, $slider);
                    unset($cat->sliderCategoryStatus);
                }
            }
        }
        
        $data['data']['categories'] = $categories;
        $data['data']['sliders'] = $sliders;
        return $data;
    }




    public function categories(Request $request){

        $lang = $request->header('accept-language');

        $data['status'] = true;
        $categories = Category::get(['id','categoryName','categoryNameAr','categoryImage','sliderCategoryStatus','categorySliderImage']);
        

        if (!empty($categories)) {
            $sliders = [];
            foreach($categories as $cat){
                $cat->categoryImage = URL::to('Admin_uploads/categories/'.$cat->categoryImage);
                $cat->categoryName = $lang == 'en' ? $cat->categoryName : $cat->categoryNameAr;
                
                if($cat->sliderCategoryStatus) {
                    
                    $slider['id'] = $cat->id;
                    $slider['name'] = $cat->categoryName;
                    $slider['image'] = URL::to('Admin_uploads/categories/'.$cat->categorySliderImage);
                    $slider['type'] = 'category';
                    array_push($sliders, $slider);
                    unset($cat->sliderCategoryStatus);
                    unset($cat->categorySliderImage);
                }
            }
        }

        $data['data']['categories'] = $categories;
        $data['data']['sliders'] = $sliders;
        return $data;
    }





    public function subCats(Request $request,$cat_id){
        $lang = $request->header('accept-language');
        $s_categories = Sub_category::where('cat_id',$cat_id)->get(['id','s_categoryName','s_categoryNameAr','s_categoryImage']);
        if(!empty($s_categories)) {
            foreach($s_categories as $cat){
                $cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$cat->s_categoryImage);

                $cat->s_categoryName = $lang == 'en' ? $cat->s_categoryName : $cat->s_categoryNameAr;
            }    
        }

        $data['status'] = true;
        $data['sub_cats'] = $s_categories;

        return $data;
    }





    public function vendorSubCats(Request $request,$cat_id,$vendor_id){

        $lang = $request->header('accept-language');
        $item_sub = Item::where('vendor_id',$vendor_id)->pluck('sub_cat_id');
        $item_sub =  array_unique($item_sub->toArray());

        $s_categories = Sub_category::whereIn('id',$item_sub)->where('cat_id',$cat_id)->get(['id','s_categoryName','s_categoryNameAr','s_categoryImage']);

        if(!empty($s_categories)) {
            foreach($s_categories as $cat){
                $cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$cat->s_categoryImage);
                $cat->s_categoryName = $lang == 'en' ? $cat->s_categoryName : $cat->s_categoryNameAr;
            }    
        }

        $data['status'] = true;
        $data['sub_cats'] = $s_categories;

        return $data;
    }




    public function items(Request $request,$s_cat_id,$vendor_id=false){

        $deviceId = $request->header('device-id');
        $main_filter = $request->header('main-filter');
        $country = $request->header('country');
        $lang = $request->header('accept-language');

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$deviceId)->first();
        }


        if (!empty($user)){
            
            $data['status'] = true;
            if($vendor_id == false) {
                $data['items'] = Item::where([
                            'sub_cat_id'=>$s_cat_id,
                            'department'=>$main_filter,
                            'country'=>$country,
                    ])->select(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->orderBy('id','DESC')->paginate(20);
            }else{
                $data['items'] = Item::where([
                            'sub_cat_id'=>$s_cat_id,
                            'vendor_id'=>$vendor_id,
                            'department'=>$main_filter,
                            'country'=>$country,
                    ])->select(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->orderBy('id','DESC')->paginate(20);
            }

            if(!empty($data['items'])){
                foreach($data['items'] as $item){
                    $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;
                    $item->itemDescribe = $lang == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();

                    $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $item->review = !empty($review) ? true : false;
                    $item->fav = !empty($fav) ? true : false;
                    $item->cart = false;

                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                        if(!empty($order_item)) {
                            $item->cart = true;
                        }
                    }

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
        $main_filter = $request->header('main-filter');
        $country = $request->header('country');
        $lang = $request->header('accept-language');

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$deviceId)->first();
        }

        if(!empty($user)){

            $data['status'] = true;
            $data['item'] = Item::where('id',$itemId)
            ->with('other_item_images')
            ->with(['reviews'=>function($query){
                $query->limit(3);
            }])->first();

            if(!empty($data['item'])){
                $s_category = Sub_category::find($data['item']->sub_cat_id);
                $category = Category::find($s_category->cat_id);
                $data['item']->categor_id = $category->id;
                $data['item']->categoryName = $lang == 'en' ? $category->categoryName : $category->categoryNameAr;
                $data['item']->s_categoryName = $lang == 'en' ? $s_category->s_categoryName : $s_category->s_categoryNameAr;

                $data['item']->itemName = $lang == 'en' ? $data['item']->itemName : $data['item']->itemNameAr;
                $data['item']->itemDescribe = $lang == 'en' ? $data['item']->itemDescribe : $data['item']->itemDescribeAr;

                $data['item']->itemImage = URL::to('uploads/itemImages/'.$data['item']->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$data['item']->id)->first();
                $review = Review::where('user_id',$user->id)
                            ->where('item_id',$data['item']->id)
                            ->first();

                $data['item']->review = !empty($review) ? true : false;
                $data['item']->fav = !empty($fav) ? true : false;
                $data['item']->cart = false;


                //item in cart?    
                $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                if(!empty($order)){
                    $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$data['item']->id])->first();
                    if(!empty($order_item)) {
                        $data['item']->cart = true;
                    }
                }
 

                $data['item']->vendor_info = Vendor::find($data['item']->vendor_id);
                $data['item']->vendor_info->vendor_image = URL::to('Admin_uploads/vendors/'.$data['item']->vendor_info->vendor_image);
                $data['item']->vendor_info->vendor_logo = URL::to('Admin_uploads/vendors/'.$data['item']->vendor_info->vendor_logo);

                if(count($data['item']->other_item_images)) {
                    foreach($data['item']->other_item_images as $otherImage){
                        $otherImage->itemImageName = URL::to('uploads/itemImages/'.$otherImage->itemImageName);
                    }
                }

                if(count($data['item']->reviews)) {
                    foreach($data['item']->reviews as $review){
                        $review->date = date("D d M,Y",strtotime($review->created_at));
                        $review->user_info = User::where('id',$review->user_id)->first(['id','name','image']);
                        $review->user_info->image = URL::to('Admin_uploads/vendors/'.$review->user_info->image);
                    }
                }

                //item property belongs to items
                $item_properties = Item_properity::where('item_id',$data['item']->id)->pluck('id');
                $item_properties =  array_unique($item_properties->toArray());
                //item property belongs to item properties
                $item_properties_plus = Item_property_plus::whereIn('properity_id',$item_properties);
                //item property belongs to admin properties
                $sub_prop = Sub_property::whereIn('id',$item_properties_plus->pluck('sub_prop_id'))->get();

                if(!empty($sub_prop)) {
                    $color = [];
                    $size = [];
                    $itemPropPlus = $item_properties_plus->pluck('id');
                    $itemPropPlus =  array_unique($itemPropPlus->toArray());

                    foreach($sub_prop as $key=>$pro){
                        $pro->sub_prop_id = $itemPropPlus[$key];
                        $pro->propertyName = $lang == 'en' ? $pro->propertyName : $pro->propertyNameAr;
                        $main_admin_prop = Property::find($pro->prop_id);
                        if (!empty($main_admin_prop) && $main_admin_prop->type == 'color') {
                            array_push($color, $pro);
                        }elseif(!empty($main_admin_prop) && $main_admin_prop->type == 'clothes_size'){
                            array_push($size, $pro);
                        }elseif(!empty($main_admin_prop) && $main_admin_prop->type == 'shoes_size'){
                            array_push($size, $pro);
                        }
                    }
                }

                $data['item']->color = $color;
                $data['item']->size = $size;

                $data['item']->s_condition = S_condition::first();
                if (!empty($data['item']->s_condition)) {
                    $data['item']->s_condition->shippingConditions = $lang == 'en' ? $data['item']->s_condition->shippingConditions : $data['item']->s_condition->shippingConditionsAr;
                    $data['item']->s_condition->image = URL::to('Admin_uploads/conditions/'.$data['item']->s_condition->image);
                }

                $data['item']->itemMayLike = Item::where(['department'=>$main_filter,
                    'country'=>$country])->limit(10)->get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'
                ]);

                if(!empty($data['item']->itemMayLike)) {
                    foreach($data['item']->itemMayLike as $itemMayLike){
                        $itemMayLike->itemName = $lang == 'en' ? $itemMayLike->itemName : $itemMayLike->itemNameAr;

                        $itemMayLike->itemImage = URL::to('uploads/itemImages/'.$itemMayLike->itemImage);
                        $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$itemMayLike->id)->first();
                        $reviewLike = Review::where('user_id',$user->id)->where('item_id',$itemMayLike->id)->first();
                        
                        $itemMayLike->review = !empty($reviewLike) ? true : false;
                        $itemMayLike->fav = !empty($fav) ? true : false;
                        $itemMayLike->cart = false;


                        //item in cart?    
                        $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                        if(!empty($order)){
                            $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$itemMayLike->id])->first();
                            if(!empty($order_item)) {
                                $itemMayLike->cart = true;
                            }
                        }
                    }
                }

                $data['item']->itemFit = Item::where(['department'=>$main_filter,
                    'country'=>$country])->limit(10)->get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'
                ]);

                if(!empty($data['item']->itemFit)) {
                    foreach($data['item']->itemFit as $itemFit){
                        $itemFit->itemName = $lang == 'en' ? $itemFit->itemName : $itemFit->itemNameAr;

                        $itemFit->itemImage = URL::to('uploads/itemImages/'.$itemFit->itemImage);
                        $favFit = User_fav_item::where('user_id',$user->id)->where('item_id',$itemFit->id)->first();
                        $reviewFit = Review::where('user_id',$user->id)->where('item_id',$itemFit->id)->first();
                        
                        $itemFit->review = !empty($reviewFit) ? true : false;
                        $itemFit->fav = !empty($favFit) ? true : false;
                        $itemFit->cart = false;


                        //item in cart?    
                        $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                        if(!empty($order)){
                            $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$itemFit->id])->first();
                            if(!empty($order_item)) {
                                $itemFit->cart = true;
                            }
                        }
                    }
                }
                
            }else{
                $data['status'] = false;
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }
        return $data;
    }




    public function addItemToFav(Request $request,$item_id){

        $deviceId = $request->header('device-id');

        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$deviceId)->first();
        }

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
                $data['status'] = true;
                $data['message'] = Lang::get('leftsidebar.Done');
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }

        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }
        return $data;
    }




    public function removeItemFromFav(Request $request,$item_id){

        $device_id = $request->header('device-id');
        
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }


        if (!empty($user)) {
            $user_id = $user->id;
            User_fav_item::where('user_id',$user_id)->where('item_id',$item_id)->delete();

            $data['status'] = true;
            $data['message'] = Lang::get('leftsidebar.Deleted');
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }
        return $data;
    }




    public function userItemsFav(Request $request){

        $main_filter = $request->header('main-filter');
        $device_id = $request->header('device-id');
        $lang = $request->header('accept-language');
        
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        if(!empty($user)) {
            $user_id = $user->id;
            $data['status'] = true;

            $fav_item_id = User_fav_item::where('user_id',$user_id)->pluck('item_id');
            $fav_item_id =  array_unique($fav_item_id->toArray());
            $data['items'] = Item::whereIn('id',$fav_item_id)
                            //->where('department',$main_filter)
                            ->get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','vendor_id']);

            if(!empty($data['items'])){
                foreach($data['items'] as $item){
                    $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;

                    $item->itemDescribe = $lang == 'en' ? $item->itemDescribe : $item->itemDescribe;
                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    
                    $item->review = !empty($review) ? true : false;
                    $item->fav = !empty($fav) ? true : false;
                    $item->cart = false;


                    //item in cart?    
                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                        if(!empty($order_item)) {
                            $item->cart = true;
                        }
                    }

                    $item->vendor_info = Vendor::find($item->vendor_id);
                }
            }

        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }
        return $data;
    }




    public function userItemReview(Request $request){

        $device_id = $request->header('device-id');
           
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }


        $item = Item::find($request->item_id);
            
        if(!empty($user)) {
            $user_id = $user->id;
            $item = Item::find($request->item_id);
            if(!empty($item)) {
                $data['status'] = true;
                $data['message'] = Lang::get('leftsidebar.Created');

                Review::create([
                    'rate'=>$request->rate,
                    'comment'=>$request->comment,
                    'user_id'=>$user->id,
                    'item_id'=>$item->id,
                ]);

            $itemSumRate = Review::where('item_id',$item->id)->sum('rate');    
            $itemRateCount = Review::where('item_id',$item->id)->count();
            $itemAverageRate = $itemSumRate / $itemRateCount;
            $item->rate = $itemAverageRate;
            $item->save();

            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }

        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }
        return $data;
    }




    public function itemReviews(Request $request,$item_id){

        $device_id = $request->header('device-id');
            
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        $data['status'] = true;
        $data['reviews'] = Review::where('item_id',$item_id)->get();

        if(!empty($data['reviews'])){
            foreach($data['reviews'] as $review){
                $review->date = date("D d M,Y",strtotime($review->created_at));
                $review->user_info = User::where('id',$review->user_id)->first(['id','name','image']);

                if(!empty($user->image)){
                    if(substr($user->image, 0, 4) === "user"){
                        $review->user_info->image = URL::to('uploads/users/'.$user->image);
                    }
                }else{
                    $review->user_info->image = URL::to('uploads/users/defaultLogo.jpg');
                }
            }  
        }

        return $data;
    }




    //still only example
    public function itemMayLike(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $main_filter = $request->header('main-filter');
        $lang = $request->header('accept-language');
            
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        
        $data['status'] = true;
        $data['items'] = Item::get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue']);


        if(!empty($data['items'])){
            foreach($data['items'] as $item){
                $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;

                $item->itemDescribe = $lang == 'en' ? $item->itemDescribe : $item->itemDescribeAr;
                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();
                
                $item->review = !empty($review) ? true : false;
                $item->fav = !empty($fav) ? true : false;
                $item->cart = false;


                //item in cart?    
                $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                if(!empty($order)){
                    $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                    if(!empty($order_item)) {
                        $item->cart = true;
                    }
                }
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }




    public function itemFit(Request $request,$item_id){

        $device_id = $request->header('device-id');
        $main_filter = $request->header('main-filter');
        $lang = $request->header('accept-language');
            
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        $data['status'] = true;
        $data['items'] = Item::get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

        if(!empty($data['items'])){
            foreach($data['items'] as $item){
                $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;
                $item->itemDescribe = $lang == 'en' ? $item->itemDescribe : $item->itemDescribeAr;
                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();
                
                $item->review = !empty($review) ? true : false;
                $item->fav = !empty($fav) ? true : false;
                $item->cart = false;


                //item in cart?    
                $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                if(!empty($order)){
                    $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                    if(!empty($order_item)) {
                        $item->cart = true;
                    }
                }
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }




    public function properties(Request $request){
        $data['status'] = true;
        $prop_ids = Property::pluck('id');
        $prop_ids =  array_unique($prop_ids->toArray());
        $sub_props = Sub_property::whereIn('prop_id',$prop_ids)->get();
        $lang = $request->header('accept-language');

        if (!empty($sub_props)) {

            $data['color'] = [];
            $data['clothes_size'] = [];
            $data['shoes_size'] = [];

            foreach($sub_props as $sub_prop){
                $sub_prop->propertyName = $lang == 'en' ? $sub_prop->propertyName : $sub_prop->propertyNameAr;
                $prop = Property::find($sub_prop->prop_id);

                if(!empty($prop) && $prop->type == 'color'){
                    array_push($data['color'],$sub_prop);
                }elseif(!empty($prop) && $prop->type == 'clothes_size'){
                    array_push($data['clothes_size'],$sub_prop);
                }elseif(!empty($prop) && $prop->type == 'shoes_size'){
                    array_push($data['shoes_size'],$sub_prop);
                }
            }
        }

        return $data;
    }




    public function itemSearch(Request $request){

        $device_id = $request->header('device-id');
        $main_filter = $request->header('main-filter');
        $country = $request->header('country');
        $lang = $request->header('accept-language');
            
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        if(!empty($user)) {

            $data['status'] = true;
            $items = Item::query()->where(['department'=>$main_filter,'country'=>$country]);
           
            if(!empty($request->itemNameSearch)) {
                $itemName = $lang == "en" ? "itemName" : "itemNameAr";
                $items->where($itemName,'like',"%".$request->itemNameSearch."%");
            }

            if(!empty($request->vendor_id)){
                if (is_array($request->vendor_id)) {
                    $items->whereIn('vendor_id',$request->vendor_id);
                }
            }

            if(!empty($request->cats_ids)){
                if (is_array($request->cats_ids)) {

                    $cats =  Category::whereIn('id',$request->cats_ids)->pluck('id');
                    if(!empty($cats)) {
                        $cats =  array_unique($cats->toArray());
                        $sub_cats = Sub_category::whereIn('cat_id',$cats)->pluck('id');

                        if($sub_cats) {
                            $sub_cats =  array_unique($sub_cats->toArray());
                            $items->whereIn('sub_cat_id',$sub_cats);
                        }
                    }
                }
            }
            
            if(!empty($request->sub_cat_ids)){
                if (is_array($request->sub_cat_ids)) {
                    $items->whereIn('sub_cat_id',$request->sub_cat_ids);
                }
            }

            if(!empty($request->sub_prop_ids)){
                if (is_array($request->sub_prop_ids)) {
                    $sub_prop_ids = Item_property_plus::whereIn('sub_prop_id',$request->sub_prop_ids)->pluck('properity_id');
                    if (!empty($sub_prop_ids)) {
                        $sub_prop_ids =  array_unique($sub_prop_ids->toArray());
                        $main_prop_ids = Item_properity::whereIn('id',$sub_prop_ids)->pluck('item_id');
                        if (!empty($main_prop_ids)) {
                            $main_prop_ids =  array_unique($main_prop_ids->toArray());
                            $items->whereIn('id',$main_prop_ids);
                        }
                    }
                }
            }

            if( !empty($request->minPrice) && !empty($request->maxPrice) ){
                $items->whereBetween('itemPrice',[(Int)$request->minPrice,(Int)$request->maxPrice]);
            }


            if($request->sortType == 'priceASC'){
                $items->orderBy('itemPrice','ASC');
            }

            if($request->sortType == 'priceDESC') {
                $items->orderBy('itemPrice','DESC');
            }

            if($request->sortType == 'rateASC') {
                $items->orderBy('rate','ASC');
            }

            if($request->sortType == 'rateDESC') {
                $items->orderBy('rate','ASC');
            }
        
            $data['items'] = $items->select(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->orderBy('id','DESC')->paginate(25);

            if(!empty($data['items'])){
                foreach($data['items'] as $item){

                    $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;
                    $item->itemDescribe = $lang == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();
                
                    $item->review = !empty($review) ? true : false;
                    $item->fav = !empty($fav) ? true : false;
                    $item->cart = false;


                    //item in cart?    
                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                        if(!empty($order_item)) {
                            $item->cart = true;
                        }
                    }
                }
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }
        return $data;
    }




    public function sortType(Request $request){
        $device_id = $request->header('device-id');
        $lang = $request->header('accept-language');
            
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        if(!empty($user)) {
            $data['status'] = true;
            $data['sortType'] = Sort_type::get();

            if(!empty($data['sortType'])) {
                foreach($data['sortType'] as $sType){
                    $sType->sortTypeName = $lang == 'en' ? $sType->sortTypeName : $sType->sortTypeNameAr;
                }  
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }



    //sliders
    public function home(Request $request){

        $catSliders = Category::where('sliderHomeStatus',true)->get();
        $itemSliders = Item::where('sliderHomeStatus',true)->get();
        $main_filter = $request->header('main-filter');
        $country = $request->header('country');
        $lang = $request->header('accept-language');
        $device_id = $request->header('device-id');

        if(Auth::guard('api')->check()) {
            $user = User::find(Auth::guard('api')->id());
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        if (!empty($user)){

            $data['status'] = true;
            $sliders = [];

            if (!empty($catSliders)) {
                foreach($catSliders as $cat){
                    $slider['id'] = $cat->id;
                    $slider['name'] = $lang == 'en' ? $cat->categoryName : $cat->categoryNameAr;
                    $slider['image'] = URL::to('Admin_uploads/categories/'.$cat->categorySliderImage);
                    $slider['type'] = 'category';
                    array_push($sliders, $slider);
                }
            }

            if(!empty($itemSliders)) {
                foreach($itemSliders as $itemSlide){
                    $slider['id'] = $itemSlide->id;
                    $slider['name'] = $lang == 'en' ? $itemSlide->itemName : $itemSlide->itemNameAr;
                    $slider['image'] = URL::to('uploads/itemImages/'.$itemSlide->itemSliderImage);
                    $slider['type'] = 'item';
                    array_push($sliders, $slider);
                }
            }

            $itemMayLike = Item::where(['department'=>$main_filter,'country'=>$country])->limit(10)->get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

            if (!empty($itemMayLike)) {
                foreach($itemMayLike as $itemLike){
                    $itemLike->itemName = $lang == 'en' ? $itemLike->itemName : $itemLike->itemNameAr;

                    $itemLike->itemImage = URL::to('uploads/itemImages/'.$itemLike->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$itemLike->id)->first();
                    $reviewLike = Review::where('user_id',$user->id)->where('item_id',$itemLike->id)->first();
                    
                    $itemLike->review = !empty($reviewLike) ? true : false;
                    $itemLike->fav = !empty($fav) ? true : false;
                    $itemLike->cart = false;


                    //item in cart?    
                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$itemLike->id])->first();
                        if(!empty($order_item)) {
                            $itemLike->cart = true;
                        }
                    }
                }
            }

            $itemFit = Item::where(['department'=>$main_filter,'country'=>$country])->limit(10)->get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'
            ]);

            if(!empty($itemFit)) {
                foreach($itemFit as $fit){
                    $fit->itemName = $lang == 'en' ? $fit->itemName : $fit->itemNameAr;

                    $fit->itemImage = URL::to('uploads/itemImages/'.$fit->itemImage);
                    $favFit = User_fav_item::where('user_id',$user->id)->where('item_id',$fit->id)->first();
                    $reviewFit = Review::where('user_id',$user->id)->where('item_id',$fit->id)->first();
                    
                    $fit->review = !empty($reviewFit) ? true : false;
                    $fit->fav = !empty($favFit) ? true : false;
                    $fit->cart = false;


                    //item in cart?    
                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$fit->id])->first();
                        if(!empty($order_item)) {
                            $fit->cart = true;
                        }
                    }
                }
            }


            $recentItems = Item::where(['department'=>$main_filter,'country'=>$country])->limit(10)->get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'
            ]);

            if(!empty($recentItems)) {
                foreach($recentItems as $recentItem){
                    $recentItem->itemName = $lang == 'en' ? $recentItem->itemName : $recentItem->itemNameAr;

                    $recentItem->itemImage = URL::to('uploads/itemImages/'.$recentItem->itemImage);
                    $favFit = User_fav_item::where('user_id',$user->id)->where('item_id',$recentItem->id)->first();
                    $reviewFit = Review::where('user_id',$user->id)->where('item_id',$recentItem->id)->first();
                    
                    $recentItem->review = !empty($reviewFit) ? true : false;
                    $recentItem->fav = !empty($favFit) ? true : false;
                    $recentItem->cart = false;


                    //item in cart?    
                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$recentItem->id])->first();
                        if(!empty($order_item)) {
                            $recentItem->cart = true;
                        }
                    }
                }
            }

            $offers = Offer::get();

            if ($offers) {
                foreach ($offers as $offer) {
                    $offer->offerName = $lang != 'ar' ? $offer->offerName : $offer->offerNameAr;
                   $offer->offerImage = URL::to('Admin_uploads/offers/'.$offer->offerImage);
                }
            }


            $ads = Ad::get();

            if ($ads) {
                foreach ($ads as $ad) {
                    $ad->adImage = URL::to('Admin_uploads/ads/'.$ad->adImage);
                    $vendor = Vendor::find($ad->vendor_id);
                    $ad->vendor_name = null;
                    if(!empty($vendor)) {
                        $ad->vendor_name = $vendor->vendor_name;
                    }
                    $category = Category::find($ad->cat_id);
                    $ad->categoryName = null;
                    if(!empty($category)) {
                        $ad->categoryName = $lang == 'en' ? $category->categoryName : $category->categoryNameAr;
                    }
                }
            }


            $data['data']['sliders'] = $sliders;
            $data['data']['itemMayLike'] = $itemMayLike;
            $data['data']['itemFit'] = $itemFit;
            $data['data']['recentItems'] = $recentItems;
            $data['data']['offers'] = $offers;
            $data['data']['ads'] = $ads;
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }





    public function offerItems(Request $request,$offerId){

        $device_id = $request->header('device-id');
        $lang = $request->header('accept-language');

        if(Auth::guard('api')->check()) {
            $user = User::find(Auth::guard('api')->id());
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        $offer_item_ids = Offer_item::where('offer_id',$offerId)->pluck('item_id');
        if (!empty($offer_item_ids)){
            $offer_item_ids =  array_unique($offer_item_ids->toArray());
            $items = Item::whereIn('id',$offer_item_ids)->get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

            if(!empty($items)){
                foreach($items as $item){

                    $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;
                    $item->itemDescribe = $lang == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();

                    $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $item->review = !empty($review) ? true : false;
                    $item->fav = !empty($fav) ? true : false;
                   

                    $item->cart = false;

                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                        if(!empty($order_item)) {
                            $item->cart = true;
                        }
                    }
                }

                $data['status'] = true;
                $data['data'] = $items;
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }

        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }





    public function allOfferItems(Request $request){

        $device_id = $request->header('device-id');
        $lang = $request->header('accept-language');

        if(Auth::guard('api')->check()) {
            $user = User::find(Auth::guard('api')->id());
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        $offer_item_ids = Offer_item::pluck('item_id');
        if (!empty($offer_item_ids)){
            $offer_item_ids =  array_unique($offer_item_ids->toArray());
            $items = Item::whereIn('id',$offer_item_ids)->get(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue']);

            if(!empty($items)){
                foreach($items as $item){

                    $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;
                    $item->itemDescribe = $lang == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

                    $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();

                    $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();
                    $item->review = !empty($review) ? true : false;
                    $item->fav = !empty($fav) ? true : false;
                   

                    $item->cart = false;

                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                        if(!empty($order_item)) {
                            $item->cart = true;
                        }
                    }
                }

                $data['status'] = true;
                $data['data'] = $items;
            }else{
                $data['status'] = false;
                $data['message'] = Lang::get('leftsidebar.Empty');
            }

        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }




    public function seeMore(Request $request,$type){

        $main_filter = $request->header('main-filter');
        $country = $request->header('country');
        $lang = $request->header('accept-language');
        $device_id = $request->header('device-id');

        if(Auth::guard('api')->check()) {
            $user = User::find(Auth::guard('api')->id());
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }


        $data['status'] = true;


        if ($type == 'itemMayLike') {

            $itemMayLike = Item::where(['department'=>$main_filter,'country'=>$country])->select(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'])->orderBy('id','DESC')->paginate(25);


            if (!empty($itemMayLike)) {
                foreach($itemMayLike as $itemLike){
                    $itemLike->itemName = $lang == 'en' ? $itemLike->itemName : $itemLike->itemNameAr;

                    $itemLike->itemImage = URL::to('uploads/itemImages/'.$itemLike->itemImage);
                    $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$itemLike->id)->first();
                    $reviewLike = Review::where('user_id',$user->id)->where('item_id',$itemLike->id)->first();
                    
                    $itemLike->review = !empty($reviewLike) ? true : false;
                    $itemLike->fav = !empty($fav) ? true : false;
                    $itemLike->cart = false;


                    //item in cart?    
                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$itemLike->id])->first();
                        if(!empty($order_item)) {
                            $itemLike->cart = true;
                        }
                    }
                }
            }

            $data['items'] = $itemMayLike;

        }elseif($type == 'itemFit') {

            $itemFit = Item::where(['department'=>$main_filter,'country'=>$country])->select(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'
            ])->orderBy('id','DESC')->paginate(25);

            if(!empty($itemFit)) {
                foreach($itemFit as $fit){
                    $fit->itemName = $lang == 'en' ? $fit->itemName : $fit->itemNameAr;

                    $fit->itemImage = URL::to('uploads/itemImages/'.$fit->itemImage);
                    $favFit = User_fav_item::where('user_id',$user->id)->where('item_id',$fit->id)->first();
                    $reviewFit = Review::where('user_id',$user->id)->where('item_id',$fit->id)->first();
                    
                    $fit->review = !empty($reviewFit) ? true : false;
                    $fit->fav = !empty($favFit) ? true : false;
                    $fit->cart = false;


                    //item in cart?    
                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$fit->id])->first();
                        if(!empty($order_item)) {
                            $fit->cart = true;
                        }
                    }
                }
            }

            $data['items'] = $itemFit;

        }elseif($type == 'recentItems'){

            $recentItems = Item::where(['department'=>$main_filter,'country'=>$country])->select(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'
            ])->orderBy('id','DESC')->paginate(25);

            if(!empty($recentItems)) {
                foreach($recentItems as $recentItem){
                    $recentItem->itemName = $lang == 'en' ? $recentItem->itemName : $recentItem->itemNameAr;

                    $recentItem->itemImage = URL::to('uploads/itemImages/'.$recentItem->itemImage);
                    $favFit = User_fav_item::where('user_id',$user->id)->where('item_id',$recentItem->id)->first();
                    $reviewFit = Review::where('user_id',$user->id)->where('item_id',$recentItem->id)->first();
                    
                    $recentItem->review = !empty($reviewFit) ? true : false;
                    $recentItem->fav = !empty($favFit) ? true : false;
                    $recentItem->cart = false;


                    //item in cart?    
                    $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                    if(!empty($order)){
                        $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$recentItem->id])->first();
                        if(!empty($order_item)) {
                            $recentItem->cart = true;
                        }
                    }
                }
            }
            $data['items'] = $recentItems;
        }

        return $data;


    }






    public function ourNew(Request $request){

        $main_filter = $request->header('main-filter');
        $country = $request->header('country');
        $lang = $request->header('accept-language');
        $device_id = $request->header('device-id');

        if(Auth::guard('api')->check()) {
            $user = User::find(Auth::guard('api')->id());
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        $item_sub = Item::whereDate('created_at','<=', Carbon::today() )->where(['department'=>$main_filter,'country'=>$country])->pluck('sub_cat_id');
        $item_sub =  array_unique($item_sub->toArray());
        $s_categories = Sub_category::whereIn('id',$item_sub)->get(['id','s_categoryName','s_categoryNameAr','s_categoryImage']);

        if(!empty($s_categories)) {
            foreach($s_categories as $cat){
                $cat->s_categoryImage = URL::to('Admin_uploads/categories/subCategory/'.$cat->s_categoryImage);
                $cat->s_categoryName = $lang == 'en' ? $cat->s_categoryName : $cat->s_categoryNameAr;
            }    
        }

        $data['status'] = true;
        $data['count'] = count($item_sub);
        $data['message'] = Lang::get('leftsidebar.new items in 24 hours');
        $data['sub_cats'] = $s_categories;

        return $data;

    }






    public function ourNewItems(Request $request){
        $main_filter = $request->header('main-filter');
        $country = $request->header('country');
        $lang = $request->header('accept-language');
        $device_id = $request->header('device-id');

        if(Auth::guard('api')->check()) {
            $user = User::find(Auth::guard('api')->id());
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        $items = Item::whereDate('created_at','<=', Carbon::today() )->where(['department'=>$main_filter,'country'=>$country])->select(['id','itemName','itemNameAr','itemImage','itemPrice','itemPriceAfterDis','discountValue'
            ])->orderBy('id','DESC')->paginate(25);
        $data['status'] = false;
        if(!empty($items)){
            $data['status'] = true;
            foreach($items as $item){
                $item->itemName = $lang == 'en' ? $item->itemName : $item->itemNameAr;
                $item->itemDescribe = $lang == 'en' ? $item->itemDescribe : $item->itemDescribeAr;

                $item->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);
                $fav = User_fav_item::where('user_id',$user->id)->where('item_id',$item->id)->first();

                $review = Review::where('user_id',$user->id)->where('item_id',$item->id)->first();
                $item->review = !empty($review) ? true : false;
                $item->fav = !empty($fav) ? true : false;
                $item->cart = false;

                $order = Order::where(['user_id'=>$user->id,'status'=>'new'])->first();
                if(!empty($order)){
                    $order_item = Order_item::where(['order_id'=>$order->id,'item_id'=>$item->id])->first();
                    if(!empty($order_item)) {
                        $item->cart = true;
                    }
                }

            }
        }

        $data['items'] = $items;
        return $data;


    }





    public function privacy_policies(){
        $data['status'] = true;

        $privacy = Privacy::get();

        foreach ($privacy as $key => $priv) {
            $priv->privacyTitle = app()->getLocale() != 'ar' ? $priv->privacyTitle : $priv->privacyTitleAr;
            $priv->privacy = app()->getLocale() != 'ar' ? $priv->privacy : $priv->privacyAr;
            $priv->privacy = strip_tags($priv->privacy);
        }

        $data['data'] = $privacy;

        return $data;
    }







    public function sendTestNotifi(Request $request){

        $main_filter = $request->header('main-filter');
        $country = $request->header('country');
        $lang = $request->header('accept-language');
        $device_id = $request->header('device-id');

        if(Auth::guard('api')->check()) {
            $user = User::find(Auth::guard('api')->id());
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        //start_notifi
        $info['users'] = User::where('id',$user->id)->get();
        $info['title'] = Lang::get('leftsidebar.Confirm order');
        $info['body'] = Lang::get('leftsidebar.confirmOrderBody');
        return Helper::senNotifi($info);
        //end_notifi
    }




    public function userNotifi(Request $request){

        $device_id = $request->header('device-id');
        if(Auth::guard('api')->check()) {
            $user = User::find(Auth::guard('api')->id());
        }else{
            $user = User::where('deviceId',$device_id)->first();
        }

        $data['status'] = true;
        $data['notifiis'] = Notifii::where('user_id',$user->id)->get();

        return $data;
    }







}
