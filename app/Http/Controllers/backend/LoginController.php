<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Auth;

class loginController extends Controller
{
    function getLogin(){
        return view('backend.login.login');
    }
    function postLogin(LoginRequest $r){
        $email = $r->email;
        $password = $r->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('/admin');
        } else {
            return redirect()->back()->withErrors(['email'=>'Tài khoản hoặc mật khẩu không chính xác'])->withInput();
        }
      
    }
    function getLogout(){
        Auth::logout();
        return redirect('/login');
    }
}
