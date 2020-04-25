<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\models\Category;
use App\models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
   function getDetail($slug_prd){
       $arr = explode('-',$slug_prd);
       $id = array_pop($arr);
       $data['product'] = Product::find($id);
       $data['prd_new']=Product::where('img','<>','no-img.jpg')->orderBy('id','desc')->take(4)->get();
    return view('frontend.product.detail',$data);
   }
   function getShop(request $r){
       if ($r->start!="") {
        $data['product']=Product::where('img','<>','no-img.jpg')->whereBetween('price',[$r->start,$r->end])->orderBy('updated_at','desc')->paginate(6);
       } else {
        $data['product']=Product::where('img','<>','no-img.jpg')->orderBy('updated_at','desc')->paginate(6);
       }
        $data['category']=Category::all();
    return view('frontend.product.shop',$data);
    }
    function getProductCate($slug_cate, request $r){
        if ($r->start!="") {
            $data['product']=Category::where('slug',$slug_cate)->first()->product()->where('img','<>','no-img.jpg')->whereBetween('price',[$r->start,$r->end])->paginate(6);
        } else {
            $data['product']=Category::where('slug',$slug_cate)->first()->product()->where('img','<>','no-img.jpg')->paginate(6);
        }        
        $data['category']=Category::all();        
        return view('frontend.product.shop',$data);
    }
}
