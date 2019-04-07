<?php

namespace App\Policies;

use App\User;
use App\ReplyPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the reply post.
     *
     * @param  \App\User  $user
     * @param  \App\ReplyPost  $reply
     * @return mixed
     */
    public function update(User $user, ReplyPost $reply)
    {
        return $reply->owner_id === $user->id;
    }

    /**
     * Determine whether the user can delete the reply post.
     *
     * @param  \App\User  $user
     * @param  \App\ReplyPost  $reply
     * @return mixed
     */
    public function delete(User $user, ReplyPost $reply)
    {
        return $reply->owner_id === $user->id;
    }

    /**
     * Determine whether the user can restore the reply post.
     *
     * @param  \App\User  $user
     * @param  \App\ReplyPost  $reply
     * @return mixed
     */
    public function restore(User $user, ReplyPost $reply)
    {
        return $reply->owner_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the reply post.
     *
     * @param  \App\User  $user
     * @param  \App\ReplyPost  $reply
     * @return mixed
     */
    public function forceDelete(User $user, ReplyPost $reply)
    {
        return $reply->owner_id === $user->id;
    }
}
