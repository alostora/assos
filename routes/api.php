<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::group(['namespace'=>'Api\Users'],function(){

    Route::post('userCountery','Users_auth@userCountery');
    Route::get('vendors','Users@vendors');

    Route::get('vendorCategories/{vendor_id}','Users@vendorCategories');
    Route::get('categories','Users@categories');


    Route::get('items/{s_cat_id}/{vendor_id?}','Users@items');

    //fav items
    Route::get('addItemToFav/{item_id}','Users@addItemToFav');
    Route::get('removeItemFromFav/{item_id}','Users@removeItemFromFav');

});
