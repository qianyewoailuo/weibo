<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        // 中间件验证除了show create store方法
        // 安全起见,使用excep黑名单验证相对用only白名单验证为最佳实践
        // 用户未通过身份验证，默认将会被重定向到 /login 登录页面 可在中间件文件夹中的Authenticate.php中修改
        $this->middleware('auth',[
            'except' => ['show','create','store']
        ]);

        // 限制只能游客访问注册页面
        // 默认会重定向到/home页面,可在app\Middleware\RedirectIfAuthenticated.php修改
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

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
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    // 用户更新
    public function update(User $user, Request $request)
    {
        // 策略授权认证
        $this->authorize('update',$user);
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
