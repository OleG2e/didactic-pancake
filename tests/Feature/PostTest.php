<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    private object $user;
    private object $category;
    private object $post;
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
        $this->category = factory(Category::class)->create();
        $this->post = factory(Post::class)->create();
        $this->reply = factory(Reply::class)->create();
    }

    public function testGuestCanSeePostsInAllCategories()
    {
        $this->assertGuest();
        $this->get(route('post.all', 'all'))
            ->assertOk();
    }

    public function testGuestCanSeePostDetails()
    {
        $this->assertGuest();

        $this->get(route('post.show', ['ad', $this->post]))
            ->assertOk();
    }

    public function testGuestCanNotCreatePost()
    {
        $this->assertGuest();
        $this->get(route('post.create'))
            ->assertRedirect(route('login'));

        $this->post(route('post.store'))
            ->assertRedirect(route('login'));
    }

    public function testUsersMustConfirmEmailBeforeCreatePost()
    {
        $user = factory(User::class)->create(['email_verified_at' => null]);
        $post = factory(Post::class)->make(['owner_id' => $user->id]);
        $this->actingAs($user)
            ->post(route('post.store'), $post->toArray())
            ->assertRedirect(route('verification.notice'));
    }

    public function testUserCanSeeCreatePostForm()
    {
        $this->actingAs($this->user)
            ->get(route('post.create'))
            ->assertOk();
    }

    public function testUserCanCreatePost()
    {
        $post = factory(Post::class)->make();

        $this->actingAs($this->user)
            ->post(route('post.store'), $post->toArray())
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Объявление создано']);
        $this->assertDatabaseHas('posts', ['id' => 1]);
    }

    public function testUserCanSeeUpdatePostForm()
    {
        $this->actingAs($this->user)
            ->get(route('post.edit', ['ad', $this->post]))
            ->assertOk()
            ->assertSee($this->post->category->id)
            ->assertSee($this->post->title);
    }

    public function testUserCanUpdateOwnPost()
    {
        $postUpdated = factory(Post::class)->make(['title' => 'New Title']);

        $this->actingAs($this->user)
            ->patch(route('post.update', ['ad', $this->post]), $postUpdated->toArray())
            ->assertStatus(302)
            ->assertRedirect(route('post.show', ['ad', $this->post]))
            ->assertSessionHas(['message' => 'Объявление изменено']);
        $this->assertDatabaseHas('posts', ['title' => 'New Title']);
    }

    public function testPostMustHaveDescription()
    {
        $post = factory(Post::class)->make(['description' => null]);
        $this->actingAs($this->user)
            ->post(route('post.store'), $post->toArray())
            ->assertSessionHasErrors('description');
    }

    public function testPostMustHaveTitle()
    {
        $post = factory(Post::class)->make(['title' => null]);
        $this->actingAs($this->user)
            ->post(route('post.store'), $post->toArray())
            ->assertSessionHasErrors('title');
    }

    public function testPostMustHaveValidCategory()
    {
        $post = factory(Post::class)->make(['category_id' => null]);

        $this->actingAs($this->user)
            ->post(route('post.store'), $post->toArray())
            ->assertSessionHasErrors('category_id');

        $post = factory(Post::class)->make(['category_id' => 999]);
        $this->post(route('post.store'), $post->toArray())
            ->assertSessionHasErrors('category_id');
    }

    public function testGuestCanNotDeletePost()
    {
        $this->assertGuest();
        $this->delete(route('post.destroy', ['ad', $this->post]))
            ->assertRedirect('/login');
    }

    public function testUserCanDeleteOwnPost()
    {
//        $post = factory(Post::class)->create(['owner_id' => $this->user->id]);
//        $replies = factory(Reply::class, 5)->create(['post_id' => $post->id]);
        $this->actingAs($this->user)
            ->delete(route('post.destroy', ['buy', $this->post]))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Объявление удалено']);

        $this->assertDatabaseMissing('posts', ['id' => $this->post->id]);
        $this->assertDatabaseMissing('replies', ['post', $this->post, $this->reply]);
    }

    public function testUserCanNotDeleteNotOwnPost()
    {
        $post = factory(Post::class)->create(['owner_id' => 256]);

        $this->actingAs($this->user)
            ->delete(route('post.destroy', ['ad', $post]))
            ->assertStatus(403);
    }

    public function testUserCanRequestLinkToOwnerPost()
    {
        $user = factory(User::class, 2)->create();

        $this->actingAs($user[1])
            ->post(route('post.link.request', ['ad', $this->post]))
            ->assertSessionHas(['message' => "Запрос отправлен {$this->post->owner->name}"]);
    }
}