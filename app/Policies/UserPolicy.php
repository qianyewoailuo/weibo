<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // 更新策略授权
    // update两个参数其中第一个为当前用户,第二个是被授权用户,当二者id相同时授权通过
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    // 删除策略授权
    public function destroy(User $currentUser,User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
