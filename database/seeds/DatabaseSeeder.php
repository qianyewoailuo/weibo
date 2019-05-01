<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Model::unguard();
        // 用户数据填充
        $this->call(UsersTableSeeder::class);
        // 微博动态数据填充
        $this->call(StatusesTableSeeder::class);
        // 关注与粉丝数据填充
        $this->call(FollowersTableSeeder::class);
        Model::reguard();
    }
}
