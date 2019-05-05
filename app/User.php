<?php

namespace App;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'link', 'law',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function trips()
    {
        return $this->belongsToMany(Trip::class);
    }

    public function avatar()
    {
        $path = 'storage/avatars/'.$this->id.'/avatar.jpg';

        return asset(file_exists($path) ? $path : 'avatars/user-circle-solid.svg');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->as('role');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}
