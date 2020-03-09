<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\Role;
use App\Trip;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    private object $user;
    private object $trip;
    private object $post;
    private object $category;

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
        $this->trip = factory(Trip::class)->create();
        $this->post = factory(Post::class)->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGuestCanSendPasswordResetNotification()
    {
        $this->get(route('password.request'))
            ->assertOk();

        $this->post(route('password.email'), ['email' => $this->user->email])
            ->assertSessionHas(['status' => 'Ссылка на сброс пароля была отправлена!']);
    }

    public function testGuestMustSendValidEmailForPasswordResetNotification()
    {
        $this->post(route('password.email'), ['email' => 'qwerty@kd.ru'])
            ->assertSessionHasErrors(['email']);
    }

    public function testGuestCanNotSeeHomePage()
    {
        $this->assertGuest();
        $this->get(route('home'))
            ->assertRedirect(route('login'));
    }

    public function testUserCanSeeHomePage()
    {
        $this->actingAs($this->user)
            ->get(route('home'))
            ->assertOk();
    }

    public function testUserCanUpdateOwnLink()
    {
        $this->actingAs($this->user)
            ->from('/home')
            ->post(route('home.store'), ['link' => 'vkontakte'])
            ->assertRedirect('/home');

        $this->get('/home')->assertSee('vkontakte');
    }

    public function testUserCanSeeOwnPosts()
    {
        $user = factory(User::class)->create(['id' => 256]);
        $post = factory(Post::class)->create(['owner_id' => 256, 'description' => 'Post Description']);
        $postAnotherUser = factory(Post::class)->create(['description' => 'Another Description']);

        $this->actingAs($user)
            ->get(route('my.posts'))
            ->assertSee('Post Description')
            ->assertDontSee('Another Description');
    }

    public function testUserCanSeeOwnTrips()
    {
        $user = factory(User::class)->create(['id' => 256]);
        $trip = factory(Trip::class)->create(['owner_id' => 256, 'description' => 'Trip Description']);
        $tripAnotherUser = factory(Trip::class)->create(['description' => 'Another Description']);

        $user->trips()->attach($trip);
        $this->user->trips()->attach($tripAnotherUser);

        $this->actingAs($user)
            ->get(route('my.trips'))
            ->assertSee('Trip Description')
            ->assertDontSee('Another Description');
    }

    public function testUserCanSeeOwnDeliveries()
    {
        $user = factory(User::class)->create(['id' => 256]);
        $trip = factory(Trip::class)->create([
            'category_id' => 3, 'owner_id' => 256, 'description' => 'Delivery Description'
        ]);
        $tripAnotherUser = factory(Trip::class)->create(['category_id' => 3, 'description' => 'Another Description']);

        $this->actingAs($user)
            ->get(route('my.deliveries'))
            ->assertSee('Delivery Description')
            ->assertDontSee('Another Description');
    }

    public function testUserCanSeeFeedbackForm()
    {
        $this->actingAs($this->user)
            ->get(route('feedback.form'))
            ->assertOk();
    }

    public function testUserCanSendFeedbackSubmit()
    {
        $this->actingAs($this->user)
            ->post(route('feedback.submit'))
            ->assertSessionHas(['message' => 'Твоё сообщение было отправлено админу']);
    }

    public function testOnlyAdminCanSeeFeedbackForm()
    {
        $user = factory(User::class)->create(['id' => 256]);
        $roleAdmin = factory(Role::class)->create(['title' => 'admin']);
        $roleUser = factory(Role::class)->create(['title' => 'user']);

        $this->assertGuest();
        $this->get(route('admin.feedback.form'))
            ->assertRedirect(route('login'));

        $this->user->roles()->attach(1); //admin
        $user->roles()->attach(2); //user

        $this->actingAs($user)
            ->get(route('admin.feedback.form'))
            ->assertRedirect('/');

        $this->actingAs($this->user)
            ->get(route('admin.feedback.form'))
            ->assertOk();
    }

    public function testOnlyAdminCanSendFeedbackSubmit()
    {
        $user = factory(User::class)->create(['id' => 256]);
        $roleAdmin = factory(Role::class)->create(['title' => 'admin']);
        $roleUser = factory(Role::class)->create(['title' => 'user']);

        $this->assertGuest();
        $this->post(route('admin.feedback.submit'))
            ->assertRedirect(route('login'));

        $this->user->roles()->attach(1); //admin
        $user->roles()->attach(2); //user

        $this->actingAs($user)
            ->post(route('admin.feedback.submit'))
            ->assertRedirect('/');

        $this->actingAs($this->user)
            ->post(route('admin.feedback.submit'), ['message' => 'Message to User', 'email' => 'example@kd.ru'])
            ->assertRedirect(route('home'))
            ->assertSessionHas(['message' => 'Твоё сообщение было отправлено юзеру']);
    }

    public function testMainPage()
    {
        $this->assertGuest();

        $this->get('/')
            ->assertSee($this->post->title);
    }

    public function testUserCanChangeRelevancePost()
    {
        $this->actingAs($this->user);

        $this->patch(route('update.relevance.post', $this->post), [])
            ->assertStatus(302);
        $this->assertDatabaseHas('posts', ['relevance' => false]);
    }

    public function testUserCanChangeRelevanceTrip()
    {
        $this->actingAs($this->user);

        $this->patch(route('update.relevance.trip', $this->trip), [])
            ->assertStatus(302);
        $this->assertDatabaseHas('trips', ['relevance' => false]);
    }

    public function testUserCanChangeRelevanceDelivery()
    {
        $this->actingAs($this->user);

        $this->patch(route('update.relevance.delivery', $this->trip), [])
            ->assertStatus(302);
        $this->assertDatabaseHas('trips', ['relevance' => false]);
    }
}