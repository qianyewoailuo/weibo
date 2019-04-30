<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    // 创建用户
    public function create()
    {
        return view('users.create');
    }

    // 显示用户个人信息
    public function show(User $user)
    {
        // return 'show';
        return view('users.show', compact('user'));
    }

    // 保存注册信息
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'  =>  'required|max:50',
            'email' =>  'required|email|unique:users|max:255',
            'password'  =>  'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success','欢迎,您将在这里开启一段新的旅程');
        return redirect()->route('users.show',[$user]);
        // [约定优于配置] 上面等价于下面
        // return redirect()->route('users.show',[$user->id]);
    }
}
