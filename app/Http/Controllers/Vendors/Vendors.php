<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Item_property_plus;
use App\Models\Item_properity;
use App\Models\Item_image;
use \Carbon\Carbon;

use Illuminate\Contracts\Encryption\DecryptException;
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
            session()->flash('warning','error informations');
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
        
        $itemId = $itemId!= false ? Crypt::decryptString($itemId) : false;
        if($itemId != false){
            $data['item'] = Item::where('id',$itemId)->with('item_properities')->first();
        }
        return view('Vendors/Items/viewCreateItem',$data);
    }









    public function createItem(Request $request){

        $data['id'] = $request->id!= null ? Crypt::decryptString($request->id) : null;
        $data['sub_cat_id'] = $request->sub_cat_id;
        $data['withProp'] = $request->withProp;
        $data['facePage'] = $request->facePage;
        $data['videoLink'] = $request->videoLink;

        $data['itemNameAr'] = $request->itemNameAr;
        $data['itemName'] = $request->itemName;
        $data['itemDescribeAr'] = $request->itemDescribeAr;
        $data['itemDescribe'] = $request->itemDescribe;
        $data['itemPrice'] = $request->itemPrice;
        $data['discountType'] = $request->discountType;
        $data['discountValue'] = $request->discountValue;
        $data['itemCount'] = $request->itemCount;
        $data['vendor_id'] = Auth::guard('vendor')->id();
        $data['itemImage'] = $request->itemImage;
        $data['itemPriceAfterDis'] = empty($request->itemPriceAfterDis)? $request->itemPrice - ($request->itemPrice*$request->discountValue/100):$request->itemPriceAfterDis;

        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();


        $validated = $request->validate([
            'sub_cat_id'=>'required',
            'withProp'=>'required|in:hasProperty,dontHasProperty',
            'itemName'=>'required|max:100',
            'itemDescribe'=>'required|max:3000',
            'itemPrice'=>'required|numeric|min:1|max:100000',
            'discountType'=>'required|in:without,percent',
            'discountValue'=>'numeric|min:0|max:100',
            'itemCount'=>'required|numeric|min:1|max:100000',
            'otherItemImages.*' => 'mimes:jpeg,png,jpg|max:1024',
            'otherItemImages.*' => Rule::requiredIf($request->id == null),
            'itemImage' => 'mimes:jpeg,jpg,png|min:20,max:1024',
            'itemImage' => Rule::requiredIf($request->id == null),

        ]);


        if($data['id'] == null){

            if ($request->hasFile('itemImage')) {

                $itemImage = $request->file('itemImage');
                $itemImageName = '-'.Str::random(40).".".$itemImage->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/itemImages/');
                $itemImage->move($destinationPath, $itemImageName);
                $data['itemImage'] = $itemImageName;
            }


            $itemId = Item::insertGetId($data);

        }else{

            $itemId = $data['id'];
                $itemInfo = Item::find($itemId);
                $data['itemImage'] = $itemInfo->itemImage;

            if ($request->hasFile('itemImage')) {

                $itemImage = $request->file('itemImage');
                $itemImageName = '-'.Str::random(40).".".$itemImage->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/itemImages/');
                //delete old image
                File::delete($destinationPath.$itemInfo->itemImage);
                $itemImage->move($destinationPath, $itemImageName);
                $data['itemImage'] = $itemImageName;
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
                    $request->session()->flash('warning','Done');
                    return back();
                }elseif($targetNumber - $countOtherImages < $countRequestOtherImages){
                    $request->session()->flash('warning','Done');
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
                $request->session()->flash('warning',Lang::get('leftsidebar.only4Images'));
                return back();
            }
        }

        if($request->withProp === "hasProperty"){
            $countPro = $request->propCount;
            for($i=0; $i< $countPro;$i++){
                
                $propertyName = "itemProperityName".$i;
                $propertyValue = "propertyValue".$i;
                $propertyPrice = "propertyPrice".$i;

                if(is_array($request->$propertyName)){
                    foreach ($request->$propertyName as $key => $pName) {
                        $propertyId = Item_properity::insertGetId([
                            'itemProperityName' =>  $pName,
                            'item_id'   =>  $itemId
                        ]);

                        foreach ($request->$propertyValue as $keyy => $pValue) {
                            Item_property_plus::create([
                                'propertyValue' => $pValue,
                                'propertyPrice' => (int)round((int)$request->$propertyPrice[$keyy]),
                                'properity_id'  => $propertyId,
                            ]);
                        }
                    }
                }
            }
        }

        $request->session()->flash('success',Lang::get('leftsidebar.Done item add'));
        return back();
    }










    /////////////////////// stop here //////////////////////////
    function ajaxRemoveItem($itemId){

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







    function ajaxDeleteItemImage($imageId){

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
