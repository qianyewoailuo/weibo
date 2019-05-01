<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Status;

class StatusPolicy
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

    // 微博动态删除策略授权
    public function destroy(User $user, Status $status)
    {
        // 注意生成了授权策略类还必需去AuthServiceProvider.php中注册
        return $user->id === $status->user_id;
    }
}
