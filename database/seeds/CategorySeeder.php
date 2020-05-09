<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = collect();
        $slugs = collect(['ad', 'trip', 'delivery', 'buy', 'sell', 'help', 'pet', 'service', 'loss']);
        $models = ['post', 'trip', 'delivery'];
        for ($i = 0; $i < count($models); $i++) {
            $slugs->each(
                function ($slug) use ($category, $models, $i) {
                    return $category->push(
                        factory(Category::class)->create(['slug' => $slug, 'section' => $models[$i]])
                    );
                }
            );
        }
    }
}
