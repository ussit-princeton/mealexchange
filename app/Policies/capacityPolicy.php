<?php

namespace App\Policies;

use App\Models\User;
use App\Models\capacity;
use Illuminate\Auth\Access\HandlesAuthorization;

class capacityPolicy
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

    public function view(User $user, capacity $capacity) {

        return $user->permission == $capacity->group and $user->group == 'admin';
    }

    public function update(User $user, capacity $capacity) {

        return $user->permission == $capacity->group and $user->group == 'admin';
    }

    public function create(User $user, capacity $capacity) {

        return $user->permission == $capacity->group and $user->group == 'admin';
    }

}
