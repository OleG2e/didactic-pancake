<?php

namespace App\Policies;

use App\Delivery;
use App\Trip;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the trip.
     *
     * @param  User  $user
     * @param  Delivery  $delivery
     * @return boolean
     */
    public function update(User $user, Delivery $delivery): bool
    {
        return $delivery->owner_id == $user->id;
    }

    /**
     * Determine whether the user can delete the trip.
     *
     * @param  User  $user
     * @param  Delivery  $delivery
     * @return boolean
     */
    public function delete(User $user, Delivery $delivery): bool
    {
        return $delivery->owner_id == $user->id;
    }

    /**
     * Determine whether the user can restore the trip.
     *
     * @param  User  $user
     * @param  Delivery  $delivery
     * @return boolean
     */
    public function restore(User $user, Delivery $delivery): bool
    {
        return $delivery->owner_id == $user->id;
    }

    /**
     * Determine whether the user can permanently delete the trip.
     *
     * @param  User  $user
     * @param  Delivery  $delivery
     * @return boolean
     */
    public function forceDelete(User $user, Delivery $delivery): bool
    {
        return $delivery->owner_id == $user->id;
    }
}