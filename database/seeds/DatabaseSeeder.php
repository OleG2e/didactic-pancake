<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    public $category;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker;
        DB::table('users')->insert(
            [
                'username' => 'admin',
                'email' => 'oleg2e2@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'link' => 'kontakt',
                'law' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('role_user')
            ->where('user_id', 1)
            ->update(['role_id' => 1]);

        DB::table('towns')->insert(
            [
                'title' => 'Микунь',
            ]
        );

        $this->category = collect();
        $slugs = collect(['ad', 'trip', 'delivery', 'buy', 'sell', 'help', 'pet', 'service', 'loss']);
        $models = ['post', 'trip', 'delivery'];
        for ($i = 0; $i < 3; $i++) {
            $slugs->each(
                function ($slug) use ($faker, $models, $i) {
                    return $this->category->push(
                        factory(Category::class)->create(['slug' => $slug, 'section' => $models[$i]])
                    );
                }
            );
        }
    }
}
