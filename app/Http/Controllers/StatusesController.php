<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        // 登录用户认证限制
        $this->middleware('auth');
    }

    // 创建微博动态
    public function store(Request $request)
    {
        $this->validate($request,[
            'content'   =>  'required|max:140'
        ]);

        Auth::user()->statuses()->create([
            'content'   =>  $request->content,
        ]);

        session()->flash('success','发布成功');
        // 重定向回上一个页面
        return redirect()->back();
    }

}
