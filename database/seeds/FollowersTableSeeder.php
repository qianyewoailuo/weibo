<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取所有用户
        $users = User::all();
        // 获取第一个用户
        $user = $users->first();
        // 获取第一个用户的ID
        $user_id = $user->id;

        // 获取去除掉ID为1的所有用户ID数组
        $followers = $users->slice(1);
        // pluck()为获取指定键的集合
        $followers_ids = $followers->pluck('id')->toArray();

        // 关注除了1号用户以外的所有用户
        $user->follow($followers_ids);

        // 除了1号用户都对1号用户进行关注
        foreach ($followers as $follower) {
            $follower->follow($user_id);
        }
    }
}
