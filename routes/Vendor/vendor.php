<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'vendor'],function(){
    Route::group(['namespace' =>'Vendors'],function(){


        //unauth routes
        Route::get('login','Vendors@login');
        Route::post('doLogin','Vendors@doLogin');

        //lang
        Route::get('lang/{locale}', function ($locale) {
            Session::put('locale',$locale);
            return back();
        });


        Route::group(['middleware'=>'lang'],function(){
            Route::group(['middleware'=>"vendor:vendor"],function(){

                //auth routes
                Route::get('/','Vendors@dashBoard');
                Route::get('itemsInfo','Vendors@itemsInfo');
                Route::get('viewCreateItem/{itemId?}','Vendors@viewCreateItem');
                Route::post('createItem','Vendors@createItem');
                //sliders
                Route::get('sliderVendorInfo','Vendors@sliderVendorInfo');
                Route::get('changeItemSliderStatus/{item_id}','Vendors@changeItemSliderStatus');

                
                Route::get('ajaxRemoveItem/{itemId?}','Vendors@ajaxRemoveItem');
                Route::get('ajaxDeleteItemImage/{imageId?}','Vendors@ajaxDeleteItemImage');


                Route::any('logOut','Vendors@logOut');

            });
        });
    });
});

