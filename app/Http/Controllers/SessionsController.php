<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
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
            return redirect()->route('users.show',[Auth::user()]);
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
