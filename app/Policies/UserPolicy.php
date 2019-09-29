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

    //访问权限策略
    public function update(User $currentUser,User $user){
        return $currentUser->id === $user->id;
    }

    //删除权限策略
    public function destroy(User $currentUser,User $user){
        return $currentUser->is_admin == 1 && $currentUser->is_admin !== $user->is_admin;
    }
}
