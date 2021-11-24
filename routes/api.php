<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::group(['namespace'=>'Api\Users'],function(){

    //un auth routes
    Route::post('userCountery','Users_auth@userCountery');
    Route::post('register','Users_auth@register');
    Route::post('socialSignUp','Users_auth@socialSignUp');
    Route::post('login','Users_auth@login');
    Route::post('postForgetPass','Users_auth@postForgetPass');
    
    //Auth Routes
    Route::group(['middleware'=>'auth_user_api'],function(){
        
        Route::get('profile','Users_auth@profile');
        Route::post('changePassword','Users_auth@changePassword');
        Route::post('updateProfile','Users_auth@updateProfile');
        Route::post('addNewAddress','Users_auth@addNewAddress');
        Route::get('getAddress','Users_auth@getAddress');
        Route::get('deleteAddress/{id}','Users_auth@deleteAddress');
        
        //fav items
        Route::get('addItemToFav/{item_id}','Users@addItemToFav');
        Route::get('removeItemFromFav/{item_id}','Users@removeItemFromFav');
        Route::get('userItemsFav','Users@userItemsFav');
        Route::get('logOut','Users_auth@logOut');

        //review
        Route::post('userItemReview','Users@userItemReview');
        Route::get('itemReviews/{item_id}','Users@itemReviews');
        Route::get('itemMayLike/{item_id}','Users@itemMayLike');
        Route::get('itemFit/{item_id}','Users@itemFit');
        
        //Users_auth_actions
        Route::get('test','Users_auth_actions@test');
    });


    //un auth routes
    Route::get('vendors','Users@vendors');

    Route::get('vendorCategories/{vendor_id}','Users@vendorCategories');
    Route::get('categories','Users@categories');
    Route::get('subCats/{cat_id}','Users@subCats');
    Route::get('vendorSubCats/{cat_id}/{vendor_id}','Users@vendorSubCats');


    Route::get('items/{s_cat_id}/{vendor_id?}','Users@items');
    Route::get('itemInfo/{itemId}','Users@itemInfo');




    //properties
    Route::get('properties','Users@properties');
    //items search
    Route::any('itemSearch','Users@itemSearch');
    Route::get('sortType','Users@sortType');



    //sliders
    Route::get('home','Users@home');


});
