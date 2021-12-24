<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace'=>'Admin','prefix'=>'admin'],function(){

	//unauth routes
	Route::get('login','Admins@login');
	Route::post('doLogin','Admins@doLogin');


	//lang
	Route::get('lang/{locale}', function ($locale) {
		Session::put('locale',$locale);
	    return back();
	});


	Route::group(['middleware'=>'lang'],function(){
		//auth routes
		Route::group(['middleware'=>"admin:admin"],function(){
			Config::set('auth.defines','admin');

			//dashboard
			Route::get('/','Admins@dashboard');

			//admin
			Route::get('adminInfo','Admins@adminInfo');
			Route::get('viewCreateAdmin/{id?}','Admins@viewCreateAdmin');
			Route::post('createAdmin','Admins@createAdmin');
			Route::get('deleteAdmin/{id?}','Admins@deleteAdmin');
			Route::get('logOut','Admins@logOut');

			//orderSettings
			Route::get('orderSettings','Admins@orderSettings');
			Route::get('viewCreateOrderSettings/{settingId?}','Admins@viewCreateOrderSettings');
			Route::post('createSetting','Admins@createSetting');
			Route::get('deleteOrderSettings/{settingId?}','Admins@deleteOrderSettings');



			//categories
			Route::get('categoriesInfo','Categories@categoriesInfo');
			Route::get('viewCreateCategory/{id?}','Categories@viewCreateCategory');
			Route::post('createcategory','Categories@createcategory');
			Route::get('deleteCategory/{id}','Categories@deleteCategory');

			//sub_category
			Route::get('sub_categoriesInfo/{cat_id}','Categories@sub_categoriesInfo');
			Route::get('sub_viewCreateCategory/{cat_id}/{sub_cat_id?}','Categories@sub_viewCreateCategory');
			Route::post('sub_createCategory','Categories@sub_createCategory');

			//vendors
			Route::get('vendorsInfo','Vendors@vendorsInfo');
			Route::get('viewCreateVendor/{id?}','Vendors@viewCreateVendor');
			Route::post('createVendor','Vendors@createVendor');
			Route::get('deleteVendor/{id}','Vendors@deleteVendor');

			//properties
			Route::get('propertiesInfo','Properties@propertiesInfo');
			Route::get('viewCreateProperty/{id?}','Properties@viewCreateProperty');
			Route::post('createProperty','Properties@createProperty');
			Route::get('deleteProperty/{id}','Properties@deleteProperty');
			//sub_properties
			Route::get('sub_propertiesInfo/{propId?}','Properties@sub_propertiesInfo');
			Route::get('sub_viewCreateProperty/{propId}/{id?}','Properties@sub_viewCreateProperty');
			Route::post('sub_createProperty','Properties@sub_createProperty');
			Route::get('sub_deleteProperty/{id}','Properties@sub_deleteProperty');


			//sliders
			Route::get('sliderInfo/{type}','Sliders@sliderInfo');
			Route::get('changeCatSliderStatus/{cat_id}/{type}','Sliders@changeCatSliderStatus');
			Route::get('changeItemSliderStatus/{item_id}/{type}','Sliders@changeItemSliderStatus');

			//offers
			Route::get('offersInfo','Offers@offersInfo');
			Route::get('viewCreateOffer/{id?}','Offers@viewCreateOffer');
			Route::post('createOffer','Offers@createOffer');
			Route::get('deleteOffer/{id?}','Offers@deleteOffer');

			//offerItems
			Route::get('offerItems/{offer_id}','Offers@offerItems');
			Route::get('viewCreateOfferItem/{offer_id}','Offers@viewCreateOfferItem');
			
			Route::post('createOfferItems','Offers@createOfferItems');
			
			Route::get('deleteItemOffer/{item_id}/{offer_id}','Offers@deleteItemOffer');

			//Ads
			Route::get('adsInfo','Ads@adsInfo');
			Route::get('viewCreateAd/{id?}','Ads@viewCreateAd');
			Route::post('createAd','Ads@createAd');
			Route::get('deleteAd/{id}','Ads@deleteAd');

			//itemBackReasons
			Route::get('itemBackReasonsInfo','Admins@itemBackReasonsInfo');
			Route::get('viewCreateitemBackReason/{id?}','Admins@viewCreateitemBackReason');
			Route::post('createitemBackReason','Admins@createitemBackReason');
			Route::get('deleteitemBackReason/{id}','Admins@deleteitemBackReason');


		});
	});
});






