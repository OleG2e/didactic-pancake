<?php

namespace App\Policies;

use App\User;
use App\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the reply post.
     *
     * @param  \App\User  $user
     * @param  \App\Reply  $reply
     * @return mixed
     */
    public function update(User $user, Reply $reply): bool
    {
        return $reply->owner_id == $user->id;
    }

    /**
     * Determine whether the user can delete the reply post.
     *
     * @param  \App\User  $user
     * @param  \App\Reply  $reply
     * @return mixed
     */
    public function delete(User $user, Reply $reply): bool
    {
        return $reply->owner_id == $user->id;
    }

    /**
     * Determine whether the user can restore the reply post.
     *
     * @param  \App\User  $user
     * @param  \App\Reply  $reply
     * @return mixed
     */
    public function restore(User $user, Reply $reply): bool
    {
        return $reply->owner_id == $user->id;
    }

    /**
     * Determine whether the user can permanently delete the reply post.
     *
     * @param  \App\User  $user
     * @param  \App\Reply  $reply
     * @return mixed
     */
    public function forceDelete(User $user, Reply $reply): bool
    {
        return $reply->owner_id == $user->id;
    }
}
