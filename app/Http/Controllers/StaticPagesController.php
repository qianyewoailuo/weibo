<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    public function home()
    {
        // 获取微博动态信息
        $feed_items = [];
        if (Auth::check()){
            // 获取个人以及关注用户的微博动态
            $feed_items = Auth::user()->feed()->paginate(30);
        }
        return view('static_pages/home',compact('feed_items'));
    }

    public function help()
    {
        // return '帮助页';
        return view('static_pages/help');
    }

    public function about()
    {
        // return '关于页';
        return view('static_pages/about');
    }
}
