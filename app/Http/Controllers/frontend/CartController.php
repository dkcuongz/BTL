<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;


class CartController extends Controller
{
    function getCart(){
        $data['cart']=Cart::content();
        $data['total']=Cart::total(0,"",".");
        return view('frontend.cart.cart',$data);
    }
    function getAddCart(Request $r){
        $prd = Product::find($r->id_product);
        if ($r->quantity!='') {
            $qty = $r->quantity;
        } else {
            $qty = 1;
        }
        
        Cart::add([
            'id'=>$prd->code,
            'name'=>$prd->name,
            'qty'=>$qty,
            'price'=>$prd->price,
            'weight'=>0,
            'options'=>['img'=>$prd->img]
        ]);
        
        return redirect('cart');
    }
    public function getDelCart($rowId){
        Cart::remove($rowId);
        return redirect('cart');
    }
    public function getupdateCart($rowId, $qty){
        Cart::update($rowId, $qty);
        return 'success';
    }
}
