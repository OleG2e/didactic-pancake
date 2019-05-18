<?php

namespace Tests\Feature;

use App\Category;
use App\Reply;
use App\Town;
use App\Trip;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $category;
    protected $post;
    protected $town;
    protected $trip;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->category = factory(Category::class)->create();
        $this->town = factory(Town::class)->create();
        $this->trip = factory(Trip::class)->create();
    }

    public function testGuestCanSeeDeliveries()
    {
        $this->assertGuest();
        $this->get(route('delivery.all'))
            ->assertOk();
    }

    public function testGuestCanSeeDeliveryDetails()
    {
        $this->assertGuest();

        $this->get(route('delivery.show', $this->trip))
            ->assertOk();
    }

    public function testGuestCanNotCreateDelivery()
    {
        $this->assertGuest();
        $this->get(route('delivery.create'))
            ->assertRedirect(route('login'));

        $this->post(route('delivery.store'))
            ->assertRedirect(route('login'));
    }

    public function testUsersMustConfirmEmailBeforeCreateDelivery()
    {
        $user = factory(User::class)->create(['email_verified_at' => null]);
        $trip = factory(Trip::class)->make(['owner_id' => $user->id]);
        $this->actingAs($user)
            ->post(route('delivery.store'), $trip->toArray())
            ->assertRedirect(route('verification.notice'));
    }

    public function testUserCanSeeCreateDeliveryForm()
    {
        $this->actingAs($this->user)
            ->get(route('delivery.create'))
            ->assertOk();
    }

    public function testUserCanCreateDelivery()
    {
        $trip = [
            "startpoint_id" => 1,
            "endpoint_id" => 1,
            "date" => "2019-05-28",
            "description" => "Delivery description"
        ];
        $this->actingAs($this->user)
            ->post(route('delivery.store'), $trip)
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Передачка создана']);
        $this->assertDatabaseHas('trips', ['id' => 1]);
    }

    public function testUserCanSeeUpdateDeliveryForm()
    {
        $trip = factory(Trip::class)->create([
            'category_id' => 3,
            'owner_id' => 1,
            'startpoint_id' => 1,
            'endpoint_id' => 1,
            'passengers_count' => 0,
            'date_time' => now(),
            'description' => 'Delivery description',
            'price' => 0,
        ]);

        $this->actingAs($this->user)
            ->get(route('delivery.edit', $trip))
            ->assertOk()
            ->assertSee('Delivery description');
    }

    public function testUserCanUpdateOwnDelivery()
    {
        $tripUpdated = [
            'category_id' => 3,
            'owner_id' => 1,
            'startpoint_id' => 1,
            'endpoint_id' => 1,
            'passengers_count' => 0,
            'date' => '2019-05-28',
            'time' => '18:30:00',
            'description' => 'New Delivery description',
            'price' => 0,
        ];

        $this->actingAs($this->user)
            ->patch(route('delivery.update', $this->trip), $tripUpdated)
            ->assertStatus(302)
            ->assertRedirect(route('delivery.show', $this->trip))
            ->assertSessionHas(['message' => 'Передачка изменена']);
        $this->assertDatabaseHas('trips', ['description' => 'New Delivery description']);
    }

    public function testGuestCanNotDeleteDelivery()
    {
        $this->assertGuest();
        $this->delete(route('delivery.destroy', $this->trip))
            ->assertRedirect('/login');
    }

    public function testUserCanDeleteOwnDelivery()
    {
        $replies = factory(Reply::class, 5)->create(['post_id' => $this->trip->id, 'category_id' => 3]);
        $this->actingAs($this->user)
            ->delete(route('delivery.destroy', $this->trip))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Передачка удалена']);

        $this->assertDatabaseMissing('trips', ['id' => $this->trip->id]);
        $this->assertDatabaseMissing('replies', ['post_id' => $this->trip->id]);
    }

    public function testUserCanNotDeleteNotOwnDelivery()
    {
        $user = factory(User::class)->create();
        $trip = factory(Trip::class)->create(['owner_id' => 2]);

        $this->actingAs($this->user)
            ->delete(route('delivery.destroy', $trip))
            ->assertStatus(403);
    }

    public function testUserCanRequestLinkToOwnerDelivery()
    {
        $this->actingAs($this->user)
            ->post(route('delivery.link.request', $this->trip))
            ->assertSessionHas(['message' => "Запрос отправлен {$this->trip->owner->name}"]);
    }
}