<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testLogin()
    {
        $user = factory(User::class)->create([
            'name' => 'oleg',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('name', $user->name)
                ->type('password', 'secret')
                ->press('@login-button')
                ->assertPathIs('/home');
        });
    }
}