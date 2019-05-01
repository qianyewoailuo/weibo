<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        // 必须认证用户才可使用这里的方法
        $this->middleware('auth');
    }

    // 保存关注
    public function store(User $user)
    {
        // 非己关注授权策略
        $this->authorize('follow',$user);
        // 注意这里的AUTH::user()是登录用户,上面的$user是关注用户
        if (!Auth::user()->isFollowing($user->id)) {
            // 如果不是已关注用户就可以进行关注
            AUth::user()->follow($user->id);
        }
        session()->flash('success','关注成功');
        // 关注后返回
        return redirect()->route('users.show',$user->id);
    }

    // 取消关注
    public function destroy(User $user)
    {
        // 非己关注授权策略
        $this->authorize('follow',$user);

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }
        session()->flash('danger','已取消关注');
        return redirect()->route('users.show',$user->id);
    }
}
