<?php

namespace App\Providers;

use App\Category;
use App\Post;
use App\Town;
use App\Trip;
use App\User;
use App\ReplyPost;
use App\ReplyTrip;
use App\Policies\CategoryPolicy;
use App\Policies\PostPolicy;
use App\Policies\ReplyPostPolicy;
use App\Policies\ReplyTripPolicy;
use App\Policies\TownPolicy;
use App\Policies\TripPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Trip::class => TripPolicy::class,
        Town::class => TownPolicy::class,
        ReplyTrip::class => ReplyTripPolicy::class,
        ReplyPost::class => ReplyPostPolicy::class,
        Post::class => PostPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user) {
            return $user->roles->contains('title', 'admin');
        });
    }
}
