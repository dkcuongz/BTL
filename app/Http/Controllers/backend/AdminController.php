<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    function getAdmin (){
        $monthNow=Carbon::now()->format('m');
        $yearNow=Carbon::now()->format('Y');
        $data['month']=$monthNow;
        $data['order']=Order::where('state',1)->whereMonth('updated_at',$monthNow)->whereYear('updated_at',$yearNow);
        for($i=1;$i<=$monthNow;$i++){
            $dl['Tháng '.$i]=Order::where('state',1)->whereMonth('updated_at',$i)->whereYear('updated_at',$yearNow)->sum('total');
        }
        $data['total']=$dl;
       
        return view('backend.index',$data);
    }
}
