<?php

namespace App\Policies;

use App\User;
use App\ReplyTrip;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyTripPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the reply trip.
     *
     * @param  \App\User  $user
     * @param  \App\ReplyTrip  $reply
     * @return mixed
     */
    public function update(User $user, ReplyTrip $reply)
    {
        return $reply->owner_id === $user->id;
    }

    /**
     * Determine whether the user can delete the reply trip.
     *
     * @param  \App\User  $user
     * @param  \App\ReplyTrip  $reply
     * @return mixed
     */
    public function delete(User $user, ReplyTrip $reply)
    {
        return $reply->owner_id === $user->id;
    }

    /**
     * Determine whether the user can restore the reply trip.
     *
     * @param  \App\User  $user
     * @param  \App\ReplyTrip  $reply
     * @return mixed
     */
    public function restore(User $user, ReplyTrip $reply)
    {
        return $reply->owner_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the reply trip.
     *
     * @param  \App\User  $user
     * @param  \App\ReplyTrip  $reply
     * @return mixed
     */
    public function forceDelete(User $user, ReplyTrip $reply)
    {
        return $reply->owner_id === $user->id;
    }
}
