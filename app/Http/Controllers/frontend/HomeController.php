<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    function getHome() {
        $data['prd_new']=Product::where('img','<>','no-img.jpg')->orderBy('id','desc')->take(5)->get();
        $data['prd_feature']=Product::where('img','<>','no-img.jpg')->where('featured',1)->orderBy('id','desc')->take(5)->get();
       return view('frontend.index',$data);
   }
   function sendMail(Request $r){
       
       $data['email']= $r->email;
       Mail::send('mail', $data, function ($message) use($data){
           $message->from('ngoctai1908@gmail.com', 'jackie chan');
           
           $message->to($data['email'], 'khách hàng');
          
           $message->subject('Đăng kí nhận bản tin');
           
       });
       return redirect('/');
   }
}
