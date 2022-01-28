<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Item_property_plus;
use App\Models\Item_properity;
use App\Models\Item_image;
use App\Models\Property;
use App\Models\Sub_property;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

use Lang;
use Auth;
use Str;
use File;

class Vendors extends Controller
{


    /*START AUTH ROUTES*/
    public function login(){
        return view('MainLayouts/login');
    }





    public function doLogin(Request $request){
        
        $validated = $request->validate([
          'email' => 'required|email|max:100',
          'password' => 'required|max:100',
        ]);


        if(Auth::guard('vendor')->attempt($validated)){
            return redirect('vendor');
        }else{
            session()->flash('warning',Lang::get('leftsidebar.error_login'));
            return redirect('vendor/login');
        }

    }



    public function logOut(){
        Auth::guard('vendor')->logout();
        return redirect('vendor');
    }
    /*END AUTH ROUTES*/



/////////////////////////////////////////////////////////////////



    public function dashboard(){
        $data['items'] = count(Item::where('vendor_id',Auth::guard('vendor')->id())->get());
        return view('MainLayouts/dashboard',$data);
    }



    public function itemsInfo(){

        $data['items'] = Item::where('vendor_id',Auth::guard('vendor')->id())
                            ->with('item_properities')
                            ->with('other_item_images')
                            ->orderBy('id','DESC')
                            ->paginate(15);

        return view('Vendors/Items/itemsInfo',$data);
    }



    public function viewCreateItem($itemId=false){
        $data['categories'] = Category::with('sub_categories')->get();
        $data['properties'] = Property::with('sub_properties')->get();
        
        $itemId = $itemId != false ? Crypt::decryptString($itemId) : false;
        if($itemId != false){
            $data['item'] = Item::where('id',$itemId)->with('item_properities')->first();

            $itemMainPro = Item_properity::where('item_id',$data['item']->id)->pluck('id');
            if (!empty($itemMainPro)) {
                // code...
                $data['selectedItemSubPro'] = Item_property_plus::whereIn('properity_id',$itemMainPro)->pluck('sub_prop_id');
            }
        }
        return view('Vendors/Items/viewCreateItem',$data);
    }



    public function createItem(Request $request){


        $data['id'] = $request->id!= null ? Crypt::decryptString($request->id) : null;
        $data['department'] = $request->department;
        $data['main_prop_type'] = $request->main_prop_type;
        $data['sub_cat_id'] = $request->sub_cat_id;
        //$data['withProp'] = $request->withProp;
        $data['videoLink'] = $request->videoLink;

        $data['country'] = Auth::guard('vendor')->user()->country;//[sa,kw]
        $data['itemName'] = $request->itemName;
        $data['itemNameAr'] = $request->itemNameAr;
        $data['itemDescribeAr'] = $request->itemDescribeAr;
        $data['itemDescribe'] = $request->itemDescribe;
        $data['itemPrice'] = $request->itemPrice;
        //$data['discountType'] = $request->discountType;
        $data['discountValue'] = $request->discountValue;
        $data['itemCount'] = $request->itemCount;
        $data['vendor_id'] = Auth::guard('vendor')->id();
        $data['itemImage'] = $request->itemImage;
        $data['itemSliderImage'] = $request->itemSliderImage;
        $data['itemPriceAfterDis'] = empty($request->itemPriceAfterDis)? $request->itemPrice - ($request->itemPrice*$request->discountValue/100):$request->itemPriceAfterDis;

        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();


        $validated = $request->validate([
            'sub_cat_id'=>'required',
            'main_prop_type'=>'required',
            'department'=>'required',
            //'withProp'=>'required|in:hasProperty,dontHasProperty',
            'itemName'=>'required|max:100',
            'itemNameAr'=>'required|max:100',
            'itemDescribe'=>'required|max:3000',
            'itemDescribeAr'=>'required|max:3000',
            'itemPrice'=>'required|numeric|min:1|max:100000',
            //'discountType'=>'required|in:without,percent',
            'discountValue'=>'numeric|min:0|max:100',
            'itemCount'=>'required|numeric|min:1|max:100000',
            'otherItemImages.*' => 'mimes:jpeg,png,jpg|max:1024',
            'otherItemImages.*' => Rule::requiredIf($request->id == null),
            'itemImage' => 'mimes:jpeg,jpg,png|min:20,max:1024',
            'itemImage' => Rule::requiredIf($request->id == null),

            'itemSliderImage' => 'mimes:jpeg,jpg,png|min:20,max:1024',
            'itemSliderImage' => Rule::requiredIf($request->id == null),
        ]);


        if($data['id'] == null){

            if ($request->hasFile('itemImage')) {

                $itemImage = $request->file('itemImage');
                $itemImageName = '-'.Str::random(40).".".$itemImage->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/itemImages/');
                $itemImage->move($destinationPath, $itemImageName);
                $data['itemImage'] = $itemImageName;
            }

            if ($request->hasFile('itemSliderImage')) {

                $itemSliderImage = $request->file('itemSliderImage');
                $itemImageName = '-'.Str::random(40).".".$itemSliderImage->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/itemImages/');
                $itemSliderImage->move($destinationPath, $itemImageName);
                $data['itemSliderImage'] = $itemImageName;
            }


            $itemId = Item::insertGetId($data);

        }else{
            $itemId = $data['id'];
                $itemInfo = Item::find($itemId);
                $data['itemImage'] = $itemInfo->itemImage;
                $data['itemSliderImage'] = $itemInfo->itemSliderImage;

            if ($request->hasFile('itemImage')) {

                $itemImage = $request->file('itemImage');
                $itemImageName = '-'.Str::random(40).".".$itemImage->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/itemImages/');
                //delete old image
                File::delete($destinationPath.$itemInfo->itemImage);
                $itemImage->move($destinationPath, $itemImageName);
                $data['itemImage'] = $itemImageName;
            }

            if ($request->hasFile('itemSliderImage')) {

                $itemSliderImage = $request->file('itemSliderImage');
                $itemImageName = '-'.Str::random(40).".".$itemSliderImage->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/itemImages/');
                //delete old image
                File::delete($destinationPath.$itemInfo->itemSliderImage);
                $itemSliderImage->move($destinationPath, $itemImageName);
                $data['itemSliderImage'] = $itemImageName;
            }

            Item::where('id',$itemId)->update($data);
            Item_properity::where('item_id',$itemId)->delete();
        }


        if($request->hasFile('otherItemImages')){
            //check if product has more than 3 hmages
            $otherImages = Item_image::where('item_id',$itemId)->get();

            if (!empty($otherImages)) {

                $countOtherImages = count($otherImages);
                $countRequestOtherImages = count($request->file('otherItemImages'));
                $targetNumber = 4;

                if ($targetNumber - $countOtherImages == 0) {
                    session()->flash('warning',Lang::get('leftsidebar.Done'));
                    return back();
                }elseif($targetNumber - $countOtherImages < $countRequestOtherImages){
                    session()->flash('warning',Lang::get('leftsidebar.Done'));
                    return back();
                }

            }


            if(is_array($request->file('otherItemImages'))  && count($request->file('otherItemImages')) <= 4){
                foreach ($request->file('otherItemImages') as $key => $oImage) {
                    $oImageName = '-'.Str::random(40).".".$oImage->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/itemImages/');
                    $oImage->move($destinationPath, $oImageName);
                    Item_image::create(["itemImageName"=>$oImageName,"item_id"=>$itemId]);
                }
            }else{
                session()->flash('warning',Lang::get('leftsidebar.only4Images'));
                return back();
            }
        }
            
        if(is_array($request->sub_prop_id) && count($request->sub_prop_id)){

            foreach($request->sub_prop_id as $sub_prop_id){

                $sub_prop = Sub_property::find($sub_prop_id);
                $main_prop = Property::find($sub_prop->prop_id);

                $item_prop_main = Item_properity::create([
                    "main_prop_id" => $main_prop->id,
                    "item_id" => $itemId ,
                ]);

                Item_property_plus::create([
                    "sub_prop_id" => $sub_prop_id,
                    "properity_id" => $item_prop_main->id,
                ]);
            }
        }

        session()->flash('success',Lang::get('leftsidebar.Done item add'));
        return back();
    }



    public function sliderVendorInfo(){
        $data['items'] = Item::where('vendor_id',Auth::guard('vendor')->id())->get();
        return view('Vendors/Items/sliderVendorInfo',$data);
    }



    public function changeItemSliderStatus($item_id){
        $item = Item::where(['id' => $item_id,'vendor_id'=>Auth::guard('vendor')->id()])->first();
        if(!empty($item)){
            $item->update(['sliderVendorStatus' => !$item->sliderVendorStatus]);
        }
        session()->flash('success',Lang::get('leftsidebar.Done'));
        return back();
    }



    /////////////////////// stop here //////////////////////////
    public function ajaxRemoveItem($itemId){

        $itemId = Crypt::decryptString($itemId);
        if($itemId != false){
            $destinationPath = public_path('/uploads/itemImages/');
            $item = Item::where('id',$itemId)->where('vendor_id',Auth::guard('vendor')->id())->first();
            if (!empty($item)) {
        
                File::delete($destinationPath.$item->itemImage);
                //File::delete($destinationPath.$item->bannerImage);
                $otherImages = Item_image::where('item_id',$item->id)->get();
                if(!empty($otherImages)){
                    foreach($otherImages as $key => $oImage) {
                        File::delete($destinationPath.$oImage->itemImageName);
                    }
                }
                Item::where('id',$itemId)->delete();
            }else{
                return "false";
            }
        }else{
            return "false";
        }

        return "true";
    }



    public function ajaxDeleteItemImage($imageId){

        $imageId = Crypt::decryptString($imageId);
        $destinationPath = public_path('/uploads/itemImages/');

        if($imageId != false){
            $otherImages = Item_image::find($imageId);
            if (!empty($otherImages)) {
                File::delete($destinationPath.$otherImages->itemImageName);
                Item_image::where('id',$imageId)->delete();
            }else{
                return "false";
            }
        }else{
            return "false";
        }
        return "true";
    }





}
