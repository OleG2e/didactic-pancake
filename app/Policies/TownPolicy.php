<?php

namespace App\Policies;

use App\User;
use App\Town;
use Illuminate\Auth\Access\HandlesAuthorization;

class TownPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create towns.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->id == 1; // admin id
    }

    /**
     * Determine whether the user can update the town.
     *
     * @param  \App\User  $user
     * @param  \App\Town  $town
     * @return mixed
     */
    public function update(User $user, Town $town)
    {
        return $user->id == 1; // admin id
    }

    /**
     * Determine whether the user can delete the town.
     *
     * @param  \App\User  $user
     * @param  \App\Town  $town
     * @return mixed
     */
    public function delete(User $user, Town $town)
    {
        return $user->id == 1; // admin id
    }

    /**
     * Determine whether the user can restore the town.
     *
     * @param  \App\User  $user
     * @param  \App\Town  $town
     * @return mixed
     */
    public function restore(User $user, Town $town)
    {
        return $user->id == 1; // admin id
    }

    /**
     * Determine whether the user can permanently delete the town.
     *
     * @param  \App\User  $user
     * @param  \App\Town  $town
     * @return mixed
     */
    public function forceDelete(User $user, Town $town)
    {
        return $user->id == 1; // admin id
    }
}
