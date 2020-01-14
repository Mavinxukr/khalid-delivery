<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, $item)
    {
        $roles = $user->roles()->get();
        foreach ($roles as $role){
            if ($role->name === 'super-admin') return true;
        }
        return false;
    }

    public function view(User $user, $item)
    {
        return true;
    }

    public function delete(User $user, $item)
    {
        return true;
    }
}
