<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use Illuminate\Http\Request;
use App\models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function getCategory(){
        $data['category']=Category::all();
        return view('backend.category.category',$data);
    }
    function postCategory(AddCategoryRequest $r){
        $cate=new Category;
        $cate->name=$r->name;
        $cate->slug = Str::slug($r->name, '-');
        $cate->parent=$r->category;
        $cate->save();
        return redirect()->back()->with('thongbao','Đã thêm thành công');
    }
    function getEditCategory($idCate){
        $data['category']=Category::all();
        $data['cate']=Category::find($idCate);
        return view('backend.category.editcategory',$data);
    }
    function postEditCategory($idCate, EditCategoryRequest $r){
        $category = Category::find($idCate);
        $category->name = $r->name;
        $category->parent = $r->parent;
        $category->save();

        return redirect()->back()->with('thongbao','Đã sửa thành công');
    }
    function getDelCategory($idCate){
        $category['category']=Category::all();
        $cate=Category::find($idCate);
        // foreach ($category as $value) {
        //     if ($value->parent==$cate->id) {
        //       $value->parent=$cate->parent;
        //       $value->save();  
        //     }
        // }
        Category::where('parent',$cate->id)->update(["parent"=>"$cate->parent"]);
        $cate->delete();
        return redirect('/admin/category')->with('thongbao','Đã xóa thành công');
    }
}
