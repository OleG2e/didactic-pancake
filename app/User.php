<?php

namespace App;

use App\Interfaces\iReply;
use App\Notifications\CustomResetPasswordNotification;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class User extends Authenticatable implements MustVerifyEmail, iReply
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'link',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function replies(): LengthAwarePaginator
    {
        return $this->hasMany(Reply::class, 'owner_id')->paginate();
    }

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, 'owner_id');
    }

    public function avatar(): string
    {
        (env('APP_ENV') === 'local') ? $prefix = 'storage/' : $prefix = 'public/';
        $path = $prefix.'avatars/'.$this->id.'/avatar.jpg';

        return asset(file_exists($path) ? $path : $prefix.'avatars/user-circle-solid.svg');
    }

    public function roles(): BelongsToMany
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
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmail());
    }
}
