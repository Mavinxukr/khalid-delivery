<?php

namespace App\Policies;

use App\Models\Message\SmsToUser;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class LogPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return string
     */


    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, $item)
    {
        return true;
    }


    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, $item)
    {

        return false;
    }

    public function delete(User $user, $item)
    {
        return false;
    }

    public function restore(User $user, $item)
    {
        return false;
    }

    public function forceDelete(User $user, $item)
    {
        return false;
    }

}
