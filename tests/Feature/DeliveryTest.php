<?php

namespace Tests\Feature;

use App\Category;
use App\Reply;
use App\Town;
use App\Delivery;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $category;
    protected $town;
    protected $delivery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = collect();
        $slugs = collect(['ad', 'trip', 'delivery', 'buy', 'sell', 'help', 'pet', 'service', 'loss']);
        $slugs->each(
            function ($slug) {
                return $this->category->push(factory(Category::class)->create(['slug' => $slug]));
            }
        );

        $this->user = factory(User::class)->create();
        $this->town = factory(Town::class)->create();
        $this->delivery = factory(Delivery::class)->create();
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
        $this->get(route('delivery.show', $this->delivery))
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
        $delivery = factory(Delivery::class)->make(['owner_id' => $user->id]);
        $this->actingAs($user)
            ->post(route('delivery.store'), $delivery->toArray())
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
        $this->actingAs($this->user)
            ->post(route('delivery.store'), $this->delivery->toArray())
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Передачка создана']);
        $this->assertDatabaseHas('deliveries', ['id' => 1]);
    }

    public function testUserCanSeeUpdateDeliveryForm()
    {
        $this->actingAs($this->user)
            ->get(route('delivery.edit', $this->delivery))
            ->assertOk()
            ->assertSee($this->delivery->description);
    }

    public function testUserCanUpdateOwnDelivery()
    {
        $deliveryUpdated = factory(Delivery::class)->make(['description' => 'New description'])->toArray();

        $this->actingAs($this->user)
            ->patch(route('delivery.update', $this->delivery), $deliveryUpdated)
            ->assertStatus(302)
            ->assertRedirect(route('delivery.show', $this->delivery))
            ->assertSessionHas(['message' => 'Передачка изменена']);
        $this->assertDatabaseHas('deliveries', ['description' => 'New description']);
    }

    public function testGuestCanNotDeleteDelivery()
    {
        $this->assertGuest();
        $this->delete(route('delivery.destroy', $this->delivery))
            ->assertRedirect('/login');
    }

    public function testUserCanDeleteOwnDelivery()
    {
        $replies = factory(Reply::class, 5)->create(['model_id' => $this->delivery->id]);
        $this->actingAs($this->user)
            ->delete(route('delivery.destroy', $this->delivery))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Передачка удалена']);

        $this->assertDatabaseMissing('deliveries', ['id' => $this->delivery->id]);
        $this->assertDatabaseMissing('replies', ['model_id' => $this->delivery->id, 'model_name' => 'trip']);
    }

    public function testUserCanNotDeleteNotOwnDelivery()
    {
        $user = factory(User::class)->create();
        $trip = factory(Delivery::class)->create(['owner_id' => 2]);

        $this->actingAs($this->user)
            ->delete(route('delivery.destroy', $trip))
            ->assertStatus(403);
    }

    public function testUserCanRequestLinkToOwnerDelivery()
    {
        $this->actingAs($this->user)
            ->post(route('delivery.link.request', $this->delivery))
            ->assertSessionHas(['message' => "Запрос отправлен {$this->delivery->owner->username}"]);
    }
}