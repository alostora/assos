<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Order_item_prop;
use App\Models\Item_property_plus;
use App\Models\Sub_property;
use App\Models\Property;
use App\Models\User_address;
use App\Models\Order_setting;
use App\Models\Discount_copon;
use App\Models\user_discount_copon;
use App\Models\Item_back_reason;
use App\Models\Item_back_request;
use App\Models\Review;
use App\Models\User_fav_item;
use App\Models\Vendor;
use Auth;
use URL;
use Validator;
use Str;
use lang;
use Carbon\Carbon;

class Orders extends Controller
{
    




    public function ordersInfo(Request $request){
        

        $lang = app()->getLocale();

        $orders = Order::where('status','!=','new')
                ->with(['order_items'=>function($query){
                    $query->with('order_items_props');
                }])->get();

        if(!empty($orders)){

            foreach($orders as $order){
                $order->date = date("D d M,Y",strtotime($order->created_at));
                $order->shippingAddress = User_address::find($order->shippingAddress_id);
                $order->user_info = User::find($order->user_id);
                $orderSett = Order_setting::where('settingName',$order->shippingType)->orWhere('settingNameAr',$order->shippingType)->first();
                if(!empty($orderSett)) {
                    $order->shippingType = $lang != 'ar' ? $orderSett->settingName : $orderSett->settingNameAr;
                    $order->expectedDate = "expeted arrival date is after ".$orderSett->settingOptions ." days";
                }

                if(count($order->order_items)){
                    foreach($order->order_items as $orderItem){
                        $item = Item::find($orderItem->item_id);
                        if(!empty($item)) {
                            $orderItem->itemName = $lang != 'ar' ? $item->itemName : $item->itemNameAr;
                            $orderItem->itemPrice = $item->itemPrice;
                            $orderItem->itemPriceAfterDis = $item->itemPriceAfterDis;
                            $orderItem->discountValue = $item->discountValue;
                            $orderItem->itemImage = URL::to('uploads/itemImages/'.$item->itemImage);

                            if(count($orderItem->order_items_props)){
                                foreach($orderItem->order_items_props as $itemProp){
                                    $itemPropPlus = Item_property_plus::find($itemProp->item_prop_id);
                                    if($itemPropPlus) {
                                        $itemSubProp= Sub_property::find($itemPropPlus->sub_prop_id);
                                        if(!empty($itemSubProp)) {
                                            $itemProp->propertyName = $lang != 'ar' ? $itemSubProp->propertyName : $itemSubProp->propertyNameAr;

                                            $mainProp = Property::find($itemSubProp->prop_id);
                                            if(!empty($mainProp)) {
                                                $itemProp->type = $mainProp->type;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
    
        }

        $data['orders'] = $orders;

        //return $data;

        return view('Admin/Orders/ordersInfo',$data);
    }




    public function changeOrderStatus(Request $request,$orderId,$orderStatus){
        $order = Order::find($orderId);
        if (!empty($order)) {
            $order->status = $orderStatus;
            $order->save();
            session()->flash("success","order status changed");
            return back();
        }
    }





    public function deleteOrder($orderId){
        Order::where('id',$orderId)->delete();
        session()->flash('warning','deleted');
        return back();
    }



}
