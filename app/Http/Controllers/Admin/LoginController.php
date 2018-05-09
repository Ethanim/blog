<?php

namespace App\Http\Controllers\Admin;

require_once('resources/org/code/Code.class.php');

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class LoginController extends CommonController
{
    public function login(){
        if($input = Input::all()){
            $code = new \Code();
            $_code = $code->get();
            if(strtoupper($input['code']) != $_code){
                return back()->with('msg', '验证码错误');
            }
            $user = User::first();
            if($user->username != $input['username'] || Crypt::decrypt($user->password) != $input['password']){
                return back()->with('msg', '用户名或密码错误');
            }
            session(['user'=>$user]);
//            dd(session('user'));
            return redirect('admin');

        }else{
//            dd($_SERVER);
            return view('admin.login');
        }
    }

    public function quit(){
        session(['user' => null]);
        return redirect('admin/login');
    }

    public function code(){
        $code = new \Code();
        return $code->make();
    }

}
