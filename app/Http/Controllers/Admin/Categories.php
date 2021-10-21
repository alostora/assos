<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Sub_category;
use File;

class Categories extends Controller
{
        
    public function categoriesInfo(){
        $data['categories'] = Category::get();
        return view('Admin/Categories/categoriesInfo',$data);
    }


    public function viewCreateCategory($id = false){
        
        if(!empty($id)) {
            $data['cat'] = Category::where('id',$id)->first();
        }else{
            $data = [];
        }

        return view('Admin/Categories/viewCreateCategory',$data);
    }




    public function createcategory(Request $request){

        $validated = $request->validate([
          'categoryName' => 'required|max:100',
          'categoryNameAr' => 'required|max:100',
          'categoryImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except('_token');

        if (empty($data['id'])) {
            //add
            $data['categoryImage'] = null;

            if ($request->hasFile('categoryImage')) {
                $destinationPath = public_path('Admin_uploads/categories/');
                $categoryImage = $request->file('categoryImage');
                $data['categoryImage'] = rand(11111, 99999).'.'.$categoryImage->getClientOriginalExtension();
                $categoryImage->move($destinationPath, $data['categoryImage']);
            }

            Category::create($data);
        }else{
            //edit
            $category = Category::find($data['id']);
            $data['categoryImage'] = $category->categoryImage;

            if ($request->hasFile('categoryImage')) {
                $destinationPath = public_path('Admin_uploads/categories/');
                File::delete($destinationPath . $data['categoryImage']);
                $categoryImage = $request->file('categoryImage');
                $data['categoryImage'] = rand(11111, 99999).'.'.$categoryImage->getClientOriginalExtension();
                $categoryImage->move($destinationPath, $data['categoryImage']);
            }

            Category::where('id',$data['id'])->update($data);
        }

        $request->session()->flash('success','Done successfully');
        return redirect('admin/categoriesInfo');

    }

    public function deleteCategory($id){
        $category =Category::where('id',$id)->first();
            $destinationPath = public_path('Admin_uploads/categories/');
            File::delete($destinationPath . $category->categoryImage);
        Category::where('id',$id)->delete();

        session()->flash('success','Done successfully');
        return back();
    }


    //sub categories
    public function sub_categoriesInfo($cat_id){
        $data['categories'] = Sub_category::where('cat_id',$cat_id)->get();

        return view('Admin/Categories/sub_categoriesInfo',$data);
    }











}
