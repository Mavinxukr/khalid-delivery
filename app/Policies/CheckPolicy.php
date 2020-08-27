<?php

namespace App\Policies;

use App\Models\Order\Check;
use Illuminate\Auth\Access\HandlesAuthorization;

class CheckPolicy
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

    public function create()
    {
        return false;
    }

    public function update()
    {
        return false;
    }

    public function view()
    {
        return true;
    }

    public function delete()
    {
        return true;
    }
}
