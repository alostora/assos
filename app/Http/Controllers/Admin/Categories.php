<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class Categories extends Controller
{
        
    public function categoriesInfo(){
        $data['categories'] = Category::get();
        return view('Admin/Categories/categoriesInfo',$data);
    }


    public function viewCreateCategory(){
        return view('Admin/Categories/viewCreateCategory');
    }




    public function createcategory(Request $request){

        $validated = $request->validate([
          'categoryName' => 'required|max:100',
          'categoryNameAr' => 'required|max:100',
          'categoryImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('_token');
        $data['categoryImage'] = null;

        if ($request->hasFile('categoryImage')) {
            $categoryImage = $request->file('categoryImage');
            $data['categoryImage'] = rand(11111, 99999).'.'.$categoryImage->getClientOriginalExtension();
            $destinationPath = public_path('Admin_uploads/categories');
            $categoryImage->move($destinationPath, $data['categoryImage']);
          }

         Category::create($data);

        $request->session()->flash('success','Done successfully');
        return redirect('admin/categoriesInfo');

    }





}
