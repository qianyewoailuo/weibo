<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 主页 帮助页 关于页路由
Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');

// 用户注册,登录等相关路由
Route::get('signup','UsersController@create')->name('signup');
// 邮件激活
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');
// 重设密码与重置密码相关路由
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');



// 用戶资源路由
Route::resource('users','UsersController');

// 会话控制器路由: 登录 退出登录
Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout','SessionsController@destroy')->name('logout');

// 微博动态路由
Route::resource('statuses','StatusesController',['only'=>['store','destroy']]);
/**
 * POST     /statuses   StatusesController@store    处理创建微博的请求
 * DELETE   /statuses   StatusesController@destroy	处理删除微博的请求
 */

// 关注人列表与粉丝列表路由
Route::get('users/{user}/followings','UsersController@followings')->name('users.followings');
Route::get('users/{user}/followers','UsersController@followers')->name('users.followers');
// 关注与取消关注
Route::post('/users/followers/{user}','FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}','FollowersController@destroy')->name('followers.destroy');
