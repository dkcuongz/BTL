<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;

use App\models\Category;
use App\models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    function getProduct(){
        $data['product']=Product::paginate(4);
        return view('backend.product.listproduct',$data);
    }
    
    function getAddProduct(){
        $data['cate']=Category::all();
       
        return view('backend.product.addproduct',$data);
    }
    function postAddProduct(AddProductRequest $r){
        
        $pro = new Product();
        $pro->code = $r->code;
        $pro->name = $r->name;
        $pro->slug = Str::slug($r->name, '-');
        $pro->price = $r->price;
        $pro->featured = $r->featured;
        $pro->state = $r->state;
        $pro->info =$r->info;
        $pro->describe = $r->describe;

        if ($r->hasFile('img')) {
            $file = $r->img;
            $fileName = Str::slug($r->name, '-').'.'.$file->getClientOriginalExtension();
            $pro->img = $fileName;
            $file->move('backend/img',$fileName);
            
        }else {
            $pro->img = 'no-img.jpg';
        }
        
        $pro->category_id= $r->category;
        $pro->save();
        return redirect('/admin/product')->with('thongbao','Đã thêm thành công');
    }
    function getEditProduct($idProduct){
        $data['cate']=Category::all();
        $data['product'] = Product::find($idProduct);
        
        return view('backend.product.editproduct',$data);
    }
    function postEditProduct($idProduct, EditProductRequest $r){
        
        $pro = Product::find($idProduct);

        $pro->code = $r->code;
        $pro->name = $r->name;
        $pro->slug = Str::slug($r->name, '-');
        $pro->price = $r->price;
        $pro->featured = $r->featured;
        $pro->state = $r->state;
        $pro->info =$r->info;
        $pro->describe = $r->describe;
        if ($r->hasFile('img')) {
            if ($pro->img!='no-img.jpg') {
                unlink('backend/img'.$pro->img);
            }
            $file = $r->img;
            $fileName = Str::slug($r->name, '-').'.'.$file->getClientOriginalExtension();
            $pro->img = $fileName;
            $file->move('backend/img',$fileName);
            
        }
        
        $pro->category_id= $r->category;
        
        $pro->save();
        
        return redirect('/admin/product')->with('thongbao','Đã sửa thành công');
    }
    function delProduct($idProduct){
        $pro = Product::find($idProduct)->delete();
        return redirect()->back()->with('thongbao','Đã xóa thành công');
    }
}
