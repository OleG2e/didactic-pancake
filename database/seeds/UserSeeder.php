<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'username' => 'admin',
                'email' => 'oleg2e2@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'link' => 'kontakt',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('roles')->insert(['title' => 'admin']);
        DB::table('roles')->insert(['title' => 'user']);
        DB::table('role_user')->insert(['user_id' => 1, 'role_id' => 1]);

        factory(App\User::class, 20)->create()->each(
            function ($user) {
                $user->posts()->save(factory(App\Post::class)->make());
                $user->hasMany(App\Reply::class, 'owner_id')->save(factory(App\Reply::class)->make(['model_id' => rand(1, 9)]));
                $user->trips()->save(factory(App\Trip::class)->make());
            }
        );
    }
}
