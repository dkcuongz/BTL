<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\models\Order;
use App\models\ProductOrder;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    function getCheckout(){
        $data['cart']= Cart::content();
        $data['total']=Cart::total(0,"",".");
       return view('frontend.checkout.checkout',$data);
    }
    function postCheckout(CheckoutRequest $r){
        $check = new Order();
        $check->full = $r->name;
        $check->address = $r->address;
        $check->email = $r->email;
        $check->phone = $r->phone;        
        $check->total = Cart::total(0,"","");
        $check->state = 2;
        $check->save();
        foreach (Cart::content() as $row) {
            $prd = new ProductOrder();
            $prd->code = $row->id;
            $prd->name = $row->name;
            $prd->price = $row->price;
            $prd->qty = $row->qty;
            $prd->img = $row->options->img;
            $prd->order_id = $check->id;
            $prd->save();
        }
        Cart::destroy();
        return redirect('/checkout/complete/'.$check->id.'.');
     }
    function getComplete($idOrder){       
        $data['order']=Order::find($idOrder);
        return view('frontend.checkout.complete',$data);
    }
}