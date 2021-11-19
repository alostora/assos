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
          'categoryImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',
          'categorySliderImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',
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

            if ($request->hasFile('categorySliderImage')) {
                $destinationPath = public_path('Admin_uploads/categories/');
                $categorySliderImage = $request->file('categorySliderImage');
                $data['categorySliderImage'] = rand(11111, 99999).'.'.$categorySliderImage->getClientOriginalExtension();
                $categorySliderImage->move($destinationPath, $data['categorySliderImage']);
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

            if ($request->hasFile('categorySliderImage')) {
                $destinationPath = public_path('Admin_uploads/categories/');
                File::delete($destinationPath . $data['categorySliderImage']);
                $categorySliderImage = $request->file('categorySliderImage');
                $data['categorySliderImage'] = rand(11111, 99999).'.'.$categorySliderImage->getClientOriginalExtension();
                $categorySliderImage->move($destinationPath, $data['categorySliderImage']);
            }

            Category::where('id',$data['id'])->update($data);
        }

        $request->session()->flash('success','Done successfully');
        return redirect('admin/categoriesInfo');

    }

    public function deleteCategory($id){
        $category =Category::where('id',$id)->first();
        $destinationPath = public_path('Admin_uploads/categories/');                 
        File::delete($destinationPath . $category->categoryImage );

        $s_categories = Sub_category::where('cat_id',$id)->get();
        if (!empty($s_categories)) {
            $destinationPath = public_path('Admin_uploads/categories/subCategory/');
            foreach($s_categories as $s_cat){
                File::delete($destinationPath . $s_cat->s_categoryImage );
            }
        }

        Category::where('id',$id)->delete();

        session()->flash('success','Done successfully');
        return back();
    }


    //sub categories
    public function sub_categoriesInfo($cat_id){
        $data['sub_categories'] = Sub_category::where('cat_id',$cat_id)->get();

        return view('Admin/Categories/sub_categoriesInfo',$data);
    }



    public function sub_viewCreateCategory($cat_id ,$sub_cat_id = false){
        if(!empty($sub_cat_id)){
            $data['sub_cat'] = Sub_category::where('id',$sub_cat_id)->first();
        }else{
            $data = [];
        }
        return view('Admin/Categories/sub_viewCreateCategory',$data);
    }

    public function sub_createCategory(Request $request){
        $validated = $request->validate([
          's_categoryName' => 'required|max:100',
          's_categoryNameAr' => 'required|max:100',
          's_categoryImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'cat_id' => 'required|max:100000',
        ]);

        $data = $request->except('_token');
        if(empty($data['id'])){
            
            $data['s_categoryImage'] = null;

            if ($request->hasFile('s_categoryImage')) {
                $destinationPath = public_path('Admin_uploads/categories/subCategory/');
                $s_categoryImage = $request->file('s_categoryImage');
                $data['s_categoryImage'] = rand(11111, 99999).'.'.$s_categoryImage->getClientOriginalExtension();
                $s_categoryImage->move($destinationPath, $data['s_categoryImage']);
            }
            Sub_category::create($data);

        }else{
            $s_category = Sub_category::find($data['id']);
            $data['s_categoryImage'] = $s_category->s_categoryImage;

            if ($request->hasFile('s_categoryImage')) {
                $destinationPath = public_path('Admin_uploads/categories/subCategory/');
                File::delete($destinationPath . $data['s_categoryImage']);
                $s_categoryImage = $request->file('s_categoryImage');
                $data['s_categoryImage'] = rand(11111, 99999).'.'.$s_categoryImage->getClientOriginalExtension();
                $s_categoryImage->move($destinationPath, $data['s_categoryImage']);
            }
            Sub_category::where('id',$data['id'])->update($data);
        }

        session()->flash('success','Done successfully');
        return redirect('admin/sub_categoriesInfo/'.$data['cat_id']);

    }











}
