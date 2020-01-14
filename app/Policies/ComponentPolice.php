<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComponentPolice
{
    use HandlesAuthorization;

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
        return true;
    }

    public function update(User $user, $item)
    {

        return false;
    }

    public function delete(User $user, $item)
    {
        return true;
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
