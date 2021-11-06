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

		});
	});
});






