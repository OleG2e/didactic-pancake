<?php
/**
 * Created by PhpStorm.
 * User: olegbiruk
 * Date: 2019-01-13
 * Time: 20:38
 */

namespace Tests\Unit;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
    }

    /*public function testGet()
    {
        $response = $this->json('get','/');
        $response->assertJson(['MikunCity']);
        //dd($response);
    }*/

    public function testCategoryCreating()
    {
        $response = $this->json('POST', '/categories', ['title' => 'Sally']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'title',
            ]);
    }
}
