<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        // 注册后自动登录
        Auth::login($user);
        session()->flash('success','欢迎,您将在这里开启一段新的旅程');
        return redirect()->route('users.show',[$user]);
        // [约定优于配置] 上面等价于下面
        // return redirect()->route('users.show',[$user->id]);
    }

    // 用户编辑
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    // 用户更新
    public function update(User $user, Request $request)
    {
        // 验证数据
        $this->validate($request,[
            'name'  =>  'required|max:50',
            // 优化验证密码可以不用重置
            // 'password'  => 'required|confirmed|min:6'
            'password'  =>  'nullable|confirmed|min:6'
        ]);
        // 优化更新数据
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        // 更新数据
        // $user->update([
        //     'name'  =>  $request->name,
        //     'password'  => bcrypt($request->password),
        // ]);
        // 提示修改成功并返回
        session()->flash('success','个人资料更新成功!');
        return redirect()->route('users.show',$user->id);
    }
}
