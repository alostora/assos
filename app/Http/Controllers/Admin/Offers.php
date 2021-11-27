<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\Offer_item;
use App\Models\Item;
use File;

class Offers extends Controller
{



    public function offersInfo(){
        $offers = Offer::get();
        return view('Admin/Offers/offersInfo',compact('offers'));
    }




    public function viewCreateOffer($id=false){
        $data['offer'] = false;
        if($id != false){
            $data['offer'] = Offer::find($id);
        }
        return view('Admin/Offers/viewCreateOffer',$data);
    }





    public function createOffer(Request $request){

        $validated = $request->validate([
          'offerName' => 'required|max:100',
          'offerNameAr' => 'required|max:100',
          'offerImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);

        $data = $request->except('_token');

        if(!empty($data)){
            
            $destinationPath = public_path('Admin_uploads/offers/');
            
            if ($data['id'] == null) {
                $data['offerImage'] = null;

                if ($request->hasFile('offerImage')) {
                    
                    $offerImage = $request->file('offerImage');
                    $data['offerImage'] = rand(11111, 99999).'.'.$offerImage->getClientOriginalExtension();
                    $offerImage->move($destinationPath, $data['offerImage']);
                }
                Offer::create($data);
            }else{
                $offer = Offer::find($data['id']);
                $data['offerImage'] = $offer->offerImage;

                if ($request->hasFile('offerImage')) {
                    
                    File::delete($destinationPath . $data['offerImage']);
                    $offerImage = $request->file('offerImage');
                    $data['offerImage'] = rand(11111, 99999).'.'.$offerImage->getClientOriginalExtension();
                    $offerImage->move($destinationPath, $data['offerImage']);
                }
                Offer::where('id',$data['id'])->update($data);
            }
        }

        $request->session()->flash('success','Done successfully');
        return redirect('admin/offersInfo');
    }





    public function deleteOffer($id){
        $offer = Offer::find($id);
        if(!empty($offer)){
            $destinationPath = public_path('Admin_uploads/offers/');
            File::delete($destinationPath . $offer->offerImage);
            $offer->delete();
        }

        session()->flash('warning','deleted');
        return back();
    }


    public function offerItems($offer_id){
        $itemsId = Offer_item::where('offer_id',$offer_id)->pluck('item_id');
        $items = Item::whereIn('id',$itemsId)->get();

        //return $items;
        return view('Admin/Offers/offerItems',compact('items'));
    }



    public function viewCreateOfferItem($offer_id){
        $items = Item::get();
        return view('Admin/Offers/viewCreateOfferItem',compact('items'));
    }




    public function createOfferItems(Request $request){
        $validated = $request->validate([
          'offer_id' => 'required',
          'items' => 'required|array',
        ]);

        foreach($request->items as $item){
            Offer_item::create([
                'offer_id' => $request->offer_id,
                'item_id' => $item,
            ]);
        }

        session()->flash('success','Done');
        return back();

    }

    public function deleteItemOffer($item_id ,$offer_id){
        Offer_item::where('item_id',$item_id)->where('offer_id',$offer_id)->delete();
        session()->flash('success','Done');
        return back();
    }





}
