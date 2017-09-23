<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //登录页面
    public function create()
    {

        return view('sessions.create');
    }
    
    //登录行为
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' =>'required|email|max:255',
            'password' => 'required'
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        //attempt 方法会接收一个数组来作为第一个参数，该参数提供的值将用于寻找数据库中的用户数据。
        //第二个参数可以很容易的实现记住我这个功能
        if(Auth::attempt($credentials,$request->has('remember'))){
            session()->flash('success','欢迎回来 ！');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger','很抱歉，您的邮箱跟密码不匹配！');
            return redirect()->back();
        }

    }
    //登出
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
