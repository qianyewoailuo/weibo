<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        // 访客中间件控制只有游客才可访问登录页面
        $this->middleware('guest',[
            'only'  =>  ['create']
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' =>  'required|email|max:255',
            'password'  => 'required'
        ]);
            // Auth::attempt($credentials,$is_remember)
        if (Auth::attempt($credentials,$request->has('remember'))) {
            // 成功认证
            session()->flash('success','欢迎回来!');
            // 优化登录重定向
            // 默认重定向地址
            $fallback = route('users.show',[Auth::user()]);
            // 当上次请求的记录为空时重定向到默认地址
            return redirect()->intended($fallback);
            // return redirect()->route('users.show',[Auth::user()]);
        } else {
            // 失败认证
            session()->flash('danger','很抱歉,您的邮箱和密码不匹配');
            // withInput表示保留之前用户的输入
            return redirect()->back()->withInput();
        }
        return;
    }

    // 用户登出
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');
    }
}
