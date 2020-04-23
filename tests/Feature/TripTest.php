<?php

namespace Tests\Feature;

use App\Category;
use App\Reply;
use App\Town;
use App\Trip;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TripTest extends TestCase
{
    use DatabaseMigrations;

    private object $user;
    private object $category;
    private object $post;
    private object $town;
    private object $trip;
    private object $reply;

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
        $this->trip = factory(Trip::class)->create();
        $this->reply = factory(Reply::class)->create();
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
        $trip = factory(Trip::class)->make(['date' => Carbon::tomorrow()->toDateString(), 'time' => '16:30',]);
        $this->actingAs($this->user)
            ->post(route('trip.store'), $trip->toArray())
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
            "date" => Carbon::tomorrow()->toDateString(),
            "time" => "18:30",
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
        $this->actingAs($this->user)
            ->delete(route('trip.destroy', $this->trip))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Поездка удалена']);

        $this->assertDatabaseMissing('trips', ['id' => $this->trip]);
        $this->assertDatabaseMissing('replies', ['trip', $this->trip, $this->reply]);
    }

    public function testUserCanNotDeleteNotOwnTrip()
    {
        $user = factory(User::class)->create();
        $trip = factory(Trip::class)->create(['owner_id' => 1]);

        $this->actingAs($user)
            ->delete(route('trip.destroy', $trip))
            ->assertStatus(403);
    }

    public function testGuestCanNotParticipateInTrip()
    {
        $this->assertGuest();

        $this->patch(route('trip.add.user', $this->trip), $this->trip->toArray())
            ->assertRedirect(route('login'));
    }

    public function testUserCanParticipateInTrip()
    {
        $trip = factory(Trip::class)->create(['passengers_count' => 1]);

        $this->actingAs($this->user)
            ->from(route('trip.show', $trip))
            ->patch(route('trip.add.user', $trip), $trip->toArray())
            ->assertSessionHas(['message' => 'Вы присоединились к поездке'])
            ->assertRedirect(route('trip.show', $trip));
        $this->assertDatabaseHas('trip_user', ['trip_id' => $trip->id]);
        $this->assertDatabaseHas('trip_user', ['user_id' => $this->user->id]);
    }

    public function testUserCanDeclineFromTrip()
    {
        $this->user->trips()->attach($this->trip);
        $this->assertDatabaseHas('trip_user', ['trip_id' => $this->trip->id]);
        $this->assertDatabaseHas('trip_user', ['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->from(route('trip.show', $this->trip))
            ->delete(route('trip.remove.user', $this->trip), $this->trip->toArray())
            ->assertSessionHas(['message' => 'Вы отказались от поездки'])
            ->assertRedirect(route('trip.show', $this->trip));

        $this->assertDatabaseMissing('trip_user', ['trip_id' => $this->trip->id]);
        $this->assertDatabaseMissing('trip_user', ['user_id' => $this->user->id]);
    }
}