<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws \Throwable
     */
    public function testCategoryCreate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/categories/create')
                ->type('title', 'Гомилки')
                ->press('Создать категорию')
                ->assertPathIs('/categories')
                ->assertSee('Гомилки');
        });
    }
}
