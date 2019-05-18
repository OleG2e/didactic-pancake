<?php

namespace Tests\Feature;

use App\Category;
use App\Reply;
use App\Town;
use App\Trip;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TripTest extends TestCase
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

    public function testGuestCanSeeTrips()
    {
        $this->assertGuest();
        $this->get(route('trip.all'))
            ->assertOk();
    }

    public function testGuestCanSeeTripDetails()
    {
        $this->assertGuest();

        $this->get(route('trip.show', $this->trip))
            ->assertOk();
    }

    public function testGuestCanNotCreateTrip()
    {
        $this->assertGuest();
        $this->get(route('trip.create'))
            ->assertRedirect(route('login'));

        $this->post(route('trip.store'))
            ->assertRedirect(route('login'));
    }

    public function testUsersMustConfirmEmailBeforeCreateTrip()
    {
        $user = factory(User::class)->create(['email_verified_at' => null]);
        $trip = factory(Trip::class)->make(['owner_id' => $user->id]);
        $this->actingAs($user)
            ->post(route('trip.store'), $trip->toArray())
            ->assertRedirect(route('verification.notice'));
    }

    public function testUserCanSeeCreateTripForm()
    {
        $this->actingAs($this->user)
            ->get(route('trip.create'))
            ->assertOk();
    }

    public function testUserCanCreateTrip()
    {
        $trip = [
            "startpoint_id" => 1,
            "endpoint_id" => 1,
            "passengers_count" => 4,
            "price" => "По-братски",
            "date" => "2019-05-28",
            "time" => "18:30:00",
            "description" => "Trip description"
        ];
        $this->actingAs($this->user)
            ->post(route('trip.store'), $trip)
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Поездка создана']);
        $this->assertDatabaseHas('trips', ['id' => 1]);
    }

    public function testUserCanSeeUpdateTripForm()
    {
        $this->actingAs($this->user)
            ->get(route('trip.edit', $this->trip))
            ->assertOk()
            ->assertSee($this->trip->title);
    }

    public function testUserCanUpdateOwnTrip()
    {
        $tripUpdated = [
            "startpoint_id" => 1,
            "endpoint_id" => 1,
            "passengers_count" => 4,
            "price" => "По-братски",
            "date" => "2019-05-28",
            "time" => "18:30:00",
            "description" => "New Trip description"
        ];

        $this->actingAs($this->user)
            ->patch(route('trip.update', $this->trip), $tripUpdated)
            ->assertStatus(302)
            ->assertRedirect(route('trip.show', $this->trip))
            ->assertSessionHas(['message' => 'Поездка изменена']);
        $this->assertDatabaseHas('trips', ['description' => 'New Trip description']);
    }

    public function testGuestCanNotDeleteTrip()
    {
        $this->assertGuest();
        $this->delete(route('trip.destroy', $this->trip))
            ->assertRedirect('/login');
    }

    public function testUserCanDeleteOwnTrip()
    {
        $trip = factory(Trip::class)->create(['owner_id' => $this->user->id]);
        $replies = factory(Reply::class, 5)->create(['post_id' => $trip->id]);
        $this->actingAs($this->user)
            ->delete(route('trip.destroy', $trip))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Поездка удалена']);

        $this->assertDatabaseMissing('trips', ['id' => $trip->id]);
        $this->assertDatabaseMissing('replies', ['post_id' => $trip->id]);
    }

    public function testUserCanNotDeleteNotOwnTrip()
    {
        $user = factory(User::class)->create();
        $trip = factory(Trip::class)->create(['owner_id' => 1]);

        $this->actingAs($user)
            ->delete(route('trip.destroy', $trip))
            ->assertStatus(403);
    }

    public function testUserCanCreateReply()
    {
        $reply = factory(Reply::class)->make(['post_id' => $this->trip->id]);

        $this->actingAs($this->user)
            ->post(route('reply.store'), $reply->toArray())
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Ответ создан']);
        $this->assertDatabaseHas('replies', ['id' => 1]);
    }

    public function testUserCanDeleteOwnReply()
    {
        $reply = factory(Reply::class)->create(['post_id' => $this->trip->id]);

        $this->actingAs($this->user)
            ->delete(route('reply.destroy', $reply))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Ответ удалён']);
        $this->assertDatabaseMissing('replies', ['post_id' => $this->trip->id]);
    }

    public function testUserCanSeeUpdateReplyForm()
    {
        $reply = factory(Reply::class)->create(['post_id' => $this->trip->id]);

        $this->actingAs($this->user)
            ->get(route('reply.edit', $reply))
            ->assertOk()
            ->assertSee($reply->description);
    }

    public function testUserCanUpdateOwnReply()
    {
        $reply = factory(Reply::class)->create(['post_id' => $this->trip->id]);
        $replyUpdated = factory(Reply::class)->make(['description' => 'New Title'])->toArray();

        $this->actingAs($this->user)
            ->patch(route('reply.update', $reply), $replyUpdated)
            ->assertStatus(302);
    }

    public function testUserCanNotDeleteNotOwnReply()
    {
        $reply = factory(Reply::class)->create(['post_id' => $this->trip->id, 'owner_id' => 256]);

        $this->actingAs($this->user)
            ->delete(route('reply.destroy', $reply))
            ->assertStatus(403);
    }

    public function testUserCanNotUpdateNotOwnReply()
    {
        $reply = factory(Reply::class)->create(['post_id' => $this->trip->id, 'owner_id' => 256]);

        $this->actingAs($this->user)
            ->patch(route('reply.update', $reply))
            ->assertStatus(403);
    }

    public function testUserCanRequestLinkToOwnerReply()
    {
        $user = factory(User::class, 2)->create();
        $category = factory(Category::class, 2)->create();
        $reply = factory(Reply::class)->create(['post_id' => $this->trip->id, 'owner_id' => 2, 'category_id' => 2]);

        $this->actingAs($user[0])
            ->post(route('reply.link.request', $reply))
            ->assertSessionHas(['message' => "Запрос отправлен {$reply->owner->name}"]);
    }

    public function testGuestCanNotParticipateInTrip()
    {
        $this->assertGuest();

        $this->patch(route('add.user', $this->trip), $this->trip->toArray())
            ->assertRedirect(route('login'));
    }

    public function testUserCanParticipateInTrip()
    {
        $trip = factory(Trip::class)->create(['passengers_count' => 1]);

        $this->actingAs($this->user)
            ->from(route('trip.show', $trip))
            ->patch(route('add.user', $trip), $trip->toArray())
            ->assertSessionHas(['message' => 'Вы присоединились к поездке'])
            ->assertRedirect(route('trip.show', $trip));
        $this->assertDatabaseHas('trip_user', ['trip_id' => $trip->id]);
        $this->assertDatabaseHas('trip_user', ['user_id' => $this->user->id]);
    }

    public function testUserCanDeclineFromTrip()
    {
        $user = factory(User::class)->create();

        $user->trips()->attach($this->trip);
        $this->assertDatabaseHas('trip_user', ['trip_id' => $this->trip->id]);
        $this->assertDatabaseHas('trip_user', ['user_id' => $user->id]);

        $this->actingAs($user)
            ->from(route('trip.show', $this->trip))
            ->delete(route('remove.user', $this->trip), $this->trip->toArray())
            ->assertSessionHas(['message' => 'Вы отказались от поездки'])
            ->assertRedirect(route('trip.show', $this->trip));

        $this->assertDatabaseMissing('trip_user', ['trip_id' => $this->trip->id]);
        $this->assertDatabaseMissing('trip_user', ['user_id' => $user->id]);
    }
}