<?php

namespace App\Http\Controllers\Api\Deliveries;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use App\Models\Property;
use App\Models\Sub_property;
use App\Models\Item_property_plus;
use App\Models\Item;
use App\Models\Order_setting;
use App\Models\User_address;
use Carbon\Carbon;
use Auth;
use URL;
use Lang;
use Hash;
use Str;
use File;
use Validator;

class Delivery_auth extends Controller
{
    


    public function profile(Request $request){
        if(Auth::guard('delivery')->check()) {
            $data['status'] = true;
            $data['delivery'] = Auth::guard('delivery')->user();

            if(!empty($data['delivery']->image)){
                if(substr($data['delivery']->image, 0, 8) === "delivery"){
                    $data['delivery']->image = URL::to('uploads/deliveries/'.$data['delivery']->image);
                }
            }else{
                $data['delivery']->image = URL::to('uploads/deliveries/defaultLogo.jpeg');
            }
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.plz_login');
        }

        return $data;
    }




    public function updateProfile(Request $request){

        $delivery = Auth::guard("delivery")->user();
        
        $data = $request->except(['api_token']);
        $destinationPath = public_path('uploads/deliveries/');
        $data['image'] = $delivery->image;

        $validator = Validator::make($request->all(),[
          'name' => 'required|max:100',
          'email' => 'required|unique:deliveries,email,'.$delivery->id.'|max:100',
          'phone' => 'required|unique:deliveries,phone,'.$delivery->id.'|max:100',
        ]);

        
        if($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }


        if ($request->hasFile('image')) {
            File::delete($destinationPath.$data['image']);
            $image = $request->file('image');
            $data['image'] = "delivery".Str::random(30).'.'.$image->getClientOriginalExtension();
            $image->move($destinationPath, $data['image']);
        }

        Delivery::where('id',$delivery->id)->update($data);

        $delivery = Delivery::find($delivery->id);
        
        if(!empty($delivery->image)){
            if(substr($delivery->image, 0, 8) === "delivery"){
                $delivery->image = URL::to('uploads/deliveries/'.$delivery->image);
            }
        }else{
            $delivery->image = URL::to('uploads/deliveries/defaultLogo.jpeg');
        }

        $info['status'] = true;
        $info['delivery'] = $delivery;

        return $info;
    }




    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => 'required|max:100',
            'confirmPassword' => 'same:password',
        ]);

        $delivery = Auth::guard('delivery')->user();

        if($validator->fails()) {
            $data['status'] = false;
            $err = $validator->errors()->toArray();
            $data['message'] = array_values($err)[0][0];
            return $data;
        }


        $password = Hash::make($request->password);
        $delivery = Delivery::find($delivery->id);
        $delivery->password = $password;
        $delivery->save();


        $data['status'] = true;
        $data['message'] = Lang::get('leftsidebar.Done');

        return $data;
    }







    public function logOut(){
        $id = Auth::guard('delivery')->id();
        Delivery::where('id',$id)->update(['api_token'=>null]);
        return ['status'=>true,'message'=>Lang::get('leftsidebar.Logged_out')];
    }






    //orders
    public function deliveryOrders(Request $request){
        $delivery_id = Auth::guard('delivery')->id();
        $orders = Order::where('status','salesMan')->where('delivery_id',$delivery_id)->get();

        $lang = $request->header('accept-language');

        if(!empty($orders)){

            foreach($orders as $order){
                $order->date = date("D d M,Y",strtotime($order->created_at));
                $order->canBack = $order->date >= Carbon::now()->subDays(15) ? true : false;
                $order->shippingAddress = User_address::find($order->shippingAddress_id);
                $orderSett = Order_setting::where('settingName','normalShipping')->first();
                $order->expectedDate = "expeted arrival date is after ".$orderSett->settingOptions ." days";

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

            $data['status'] = true;
            $data['order'] = $orders;
        }else{
            $data['status'] = false;
            $data['message'] = Lang::get('leftsidebar.Empty');
        }

        return $data;
    }





    public function changeOrderStatus(Request $request){
        
        $data['status'] = false;
        $data['message'] = Lang::get('leftsidebar.Empty');

        $order = Order::where(['status'=>'salesMan','id'=>$request->orderId])->first();
        if (!empty($order)) {

            $order->status = $request->orderStatus;
            $order->delivery_id = Auth::guard('delivery')->id();
            $order->save();

            $data['status'] = true;
            $data['message'] = Lang::get('leftsidebar.Updated');
        }
        return $data;

    }









}
