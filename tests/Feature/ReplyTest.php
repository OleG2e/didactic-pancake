<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    private object $user;
    private object $category;
    private object $post;
    private object $reply;
    private array $routeParameters;

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

        $this->reply = factory(Reply::class)->create();
        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class)->create();
        $this->routeParameters = ['post', $this->post, $this->reply];
    }

    public function testGuestCanSeePostReplies()
    {
        $this->assertGuest();

        $this->get(route('post.show', ['buy', $this->post]))
            ->assertOk()
            ->assertSeeText($this->reply->description);
    }

    public function testGuestCanNotCreatePostReply()
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
        $post = factory(Post::class)->create(['owner_id' => $this->user->id]);
        $reply = factory(Reply::class)->create(['model_id' => $post->id, 'model_name' => 'post']);
        $this->actingAs($this->user)
            ->delete(route('post.destroy', ['buy', $post]))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Объявление удалено']);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->assertDatabaseMissing('replies', ['model_id' => $post->id, 'model_name' => 'post']);
    }

    public function testUserCanNotDeleteNotOwnPost()
    {
        $post = factory(Post::class)->create(['owner_id' => 256]);

        $this->actingAs($this->user)
            ->delete(route('post.destroy', ['buy', $post]))
            ->assertStatus(403);
    }

    public function testUserCanCreateReply()
    {
        $reply = factory(Reply::class)->make(['model_id' => $this->post->id, 'model_name' => 'post']);
        $this->actingAs($this->user)
            ->post(route('reply.store', ['post', $this->post]), $reply->toArray())
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Ответ создан']);
        $this->assertDatabaseHas('replies', ['id' => 1]);
    }

    public function testUserCanDeleteOwnReply()
    {
        $this->actingAs($this->user)
            ->delete(route('reply.destroy', $this->routeParameters))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Ответ удалён']);
        $this->assertDatabaseMissing('replies', ['model_id' => $this->post->id, 'model_name' => 'post']);
    }

    public function testUserCanSeeUpdateReplyForm()
    {
        $this->actingAs($this->user)
            ->get(route('reply.edit', $this->routeParameters))
            ->assertOk()
            ->assertSee($this->reply->description);
    }

    public function testUserCanUpdateOwnReply()
    {
        $replyUpdated = factory(Reply::class)->make(['description' => 'New Title'])->toArray();

        $this->actingAs($this->user)
            ->patch(route('reply.update', $this->routeParameters), $replyUpdated)
            ->assertStatus(302);
    }

    public function testUserCanNotDeleteNotOwnReply()
    {
        $reply = factory(Reply::class)->create(['model_id' => $this->post->id, 'owner_id' => 256]);

        $this->actingAs($this->user)
            ->delete(route('reply.destroy', ['post', $this->post, $reply]))
            ->assertStatus(403);
    }

    public function testUserCanNotUpdateNotOwnReply()
    {
        $reply = factory(Reply::class)->create(['model_id' => $this->post->id, 'owner_id' => 256]);

        $this->actingAs($this->user)
            ->patch(route('reply.update', ['post', $this->post->id, $reply]), $reply->toArray())
            ->assertStatus(403);
    }

    public function testUserCanRequestLinkToOwnerReply()
    {
        $this->actingAs($this->user)
            ->post(route('reply.link.request', $this->routeParameters))
            ->assertSessionHas(['message' => "Запрос отправлен {$this->reply->owner->name}"]);
    }
}