<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 一个用户拥有多条微博
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    // 一个用户可以有多个粉丝
    public function followers()
    {
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    // 一个用户可以有多个关注用户
    public function followings()
    {
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    // 关注用户
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            // 因为sync()方法第一个参数必须是数组,所以当ids非数组时要转换一下
            $user_ids = compact('user_ids');
        }
        // sync($ids,false)不删除且增加
        $this->followings()->sync($user_ids,false);
    }
    // 取消关注
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }
    // 是否已关注
    public function isFollowing($user_id)
    {
        // contains()是进阶-集合中判断集合中是否含有的方法
        // 注意这里要使用contains()必须要前面返回一个结果集而不是关系对象
        return $this->followings->contains($user_id);
    }


    // 头像获取
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    // boot方法会在用户模型类完成初始化之后进行加载
    public static function boot()
    {
        parent::boot();     // TODO:change the autogenerated stub

        static::creating(function($user){
            $user->activation_token = str_random(30);
        });
    }
    // 取出当前用户发布过得微博以及关注人的微博
    public function feed()
    {
        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids,$this->id);
        // with()方法是关联模型预加载方法,避免N+1问题
        return Status::whereIn('user_id',$user_ids)
                        ->with('user')
                        ->orderBy('created_at','desc');
        // return $this->statuses()->orderBy('created_at','desc');
    }
}
