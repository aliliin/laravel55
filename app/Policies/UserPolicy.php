<?php

namespace App\Policies;

use App\User;
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

    //判断当前登录的用户，来进行可以操作的对象
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id  === $user->id;
    }
    //根据权限限定来判断是不是管理员权限
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
