<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        // 中间件验证除了show create store方法
        // 安全起见,使用excep黑名单验证相对用only白名单验证为最佳实践
        // 用户未通过身份验证，默认将会被重定向到 /login 登录页面 可在中间件文件夹中的Authenticate.php中修改
        $this->middleware('auth',[
            'except' => ['show','create','store','index','confirmEmail']
        ]);

        // 限制只能游客访问注册页面
        // 默认会重定向到/home页面,可在app\Middleware\RedirectIfAuthenticated.php修改
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    // 显示用户列表
    public function index()
    {
        // 获取分页数据
        $users = User::paginate(10);
        // 获取所有用户
        // $users = User::all();
        return view('Users.index',compact('users'));
    }
    // 用户删除
    public function destroy(User $user)
    {
        // 删除策略授权
        $this->authorize('destroy',$user);
        $username = $user->name;
        $user->delete();
        session()->flash('success','用户'.$username.'已被成功删除');
        return back();
    }

    // 创建用户(注册)
    public function create()
    {
        return view('users.create');
    }

    // 显示用户个人信息
    public function show(User $user)
    {
        // 获取个人所有微博
        $statuses = $user->statuses()->orderBy('created_at','desc')->paginate(10);
        return view('users.show', compact('user','statuses'));
    }
    // 显示用户关注信息
    public function followings(User $user)
    {
        $users = $user->followings()->paginate(20);
        $title = $user->name. '关注的人';
        return view('users.show_follow',compact('users','title'));
    }
    // 显示用户粉丝信息
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(20);
        $title = $user->name. '的粉丝';
        return view('users.show_follow',compact('users','title'));
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
        // 优化登录,需要激活邮箱才可登录
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','验证邮件已发送到你的注册邮箱,请注意查收');
        return redirect('/');

        // 注册后自动登录
        // Auth::login($user);
        // session()->flash('success','欢迎,您将在这里开启一段新的旅程');
        // return redirect()->route('users.show',[$user]);
        // [约定优于配置] 上面等价于下面
        // return redirect()->route('users.show',[$user->id]);
    }
    // 发送邮件
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        // 已配置环境 不在需要from方法
        // $from = 'qianyewoaluo@126.com';
        // $name = 'luotx';
        $to = $user->email;
        $subject = "感谢注册 weibo 应用!请确认你的邮箱";
        // Mail::send($view,$data,function($message) use (/*$from,$name,*/$to,$subject)
        Mail::send($view,$data,function($message) use ($to,$subject) {
            $message->to($to)->subject($subject);
        });
    }
    // 邮箱激活
    public function confirmEmail($token)
    {
        // firstOrFail() 表示取出一条数据,如果失败返回有个404响应
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success','恭喜你激活成功');
        return redirect()->route('users.show',[$user->id]);
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
