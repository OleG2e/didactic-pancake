<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAccessToMainPage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testLoginUser()
    {
        $response = $this->actingAs($this->user)
            ->get('/home')
            ->assertStatus(200);

    }
}
