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

    protected $user;
    protected $category;
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->category = factory(Category::class)->create();
        $this->post = factory(Post::class)->create();
    }

    public function testGuestCanSeePostsInCategories()
    {
        for ($i = 1; $i < 10; $i++) {
            $post = factory(Post::class)->create(['category_id' => $i]);
        }

        $this->assertGuest();
        $this->getJson(route('post.buy'))
            ->assertJsonFragment(['category_id' => '4'])
            ->assertJsonMissing(['category_id' => '6']);
        $this->getJson(route('post.sell'))
            ->assertJsonFragment(['category_id' => '5'])
            ->assertJsonMissing(['category_id' => '6']);
        $this->getJson(route('post.help'))
            ->assertJsonFragment(['category_id' => '6'])
            ->assertJsonMissing(['category_id' => '4']);
        $this->getJson(route('post.pet'))
            ->assertJsonFragment(['category_id' => '7'])
            ->assertJsonMissing(['category_id' => '6']);
        $this->getJson(route('post.service'))
            ->assertJsonFragment(['category_id' => '8'])
            ->assertJsonMissing(['category_id' => '6']);
        $this->getJson(route('post.loss'))
            ->assertJsonFragment(['category_id' => '9'])
            ->assertJsonMissing(['category_id' => '6']);
    }

    public function testGuestCanSeePostDetails()
    {
        $this->assertGuest();

        $this->get(route('post.show', $this->post))
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
            ->get(route('post.edit', $this->post))
            ->assertOk()
            ->assertSee($this->post->category->id)
            ->assertSee($this->post->title);
    }

    public function testUserCanUpdateOwnPost()
    {
        $postUpdated = factory(Post::class)->make(['title' => 'New Title']);

        $this->actingAs($this->user)
            ->patch(route('post.update', $this->post), $postUpdated->toArray())
            ->assertStatus(302)
            ->assertRedirect(route('post.show', $this->post))
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
        $this->delete(route('post.destroy', $this->post))
            ->assertRedirect('/login');
    }

    public function testUserCanDeleteOwnPost()
    {
        $post = factory(Post::class)->create(['owner_id' => $this->user->id]);
        $replies = factory(Reply::class, 5)->create(['post_id' => $post->id]);
        $this->actingAs($this->user)
            ->delete(route('post.destroy', $post))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Объявление удалено']);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $this->assertDatabaseMissing('replies', ['post_id' => $post->id]);
    }

    public function testUserCanNotDeleteNotOwnPost()
    {
        $post = factory(Post::class)->create(['owner_id' => 256]);

        $this->actingAs($this->user)
            ->delete(route('post.destroy', $post))
            ->assertStatus(403);
    }

    public function testUserCanCreateReply()
    {
        $reply = factory(Reply::class)->make(['post_id' => $this->post->id]);

        $this->actingAs($this->user)
            ->post(route('reply.store'), $reply->toArray())
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Ответ создан']);
        $this->assertDatabaseHas('replies', ['id' => 1]);
    }

    public function testUserCanDeleteOwnReply()
    {
        $reply = factory(Reply::class)->create(['post_id' => $this->post->id]);

        $this->actingAs($this->user)
            ->delete(route('reply.destroy', $reply))
            ->assertStatus(302)
            ->assertSessionHas(['message' => 'Ответ удалён']);
        $this->assertDatabaseMissing('replies', ['post_id' => $this->post->id]);
    }

    public function testUserCanSeeUpdateReplyForm()
    {
        $reply = factory(Reply::class)->create(['post_id' => $this->post->id]);

        $this->actingAs($this->user)
            ->get(route('reply.edit', $reply))
            ->assertOk()
            ->assertSee($reply->description);
    }

    public function testUserCanUpdateOwnReply()
    {
        $reply = factory(Reply::class)->create(['post_id' => $this->post->id]);
        $replyUpdated = factory(Reply::class)->make(['description' => 'New Title'])->toArray();

        $this->actingAs($this->user)
            ->patch(route('reply.update', $reply), $replyUpdated)
            ->assertStatus(302);
    }

    public function testUserCanNotDeleteNotOwnReply()
    {
        $post = factory(Post::class)->create(['owner_id' => 256]);
        $reply = factory(Reply::class)->create(['post_id' => $post->id, 'owner_id' => 256]);

        $this->actingAs($this->user)
            ->delete(route('reply.destroy', $reply))
            ->assertStatus(403);
    }

    public function testUserCanNotUpdateNotOwnReply()
    {
        $post = factory(Post::class)->create(['owner_id' => 256]);
        $reply = factory(Reply::class)->create(['post_id' => $post->id, 'owner_id' => 256]);

        $this->actingAs($this->user)
            ->patch(route('reply.update', $reply))
            ->assertStatus(403);
    }

    public function testUserCanRequestLinkToOwnerPost()
    {
        $user = factory(User::class, 2)->create();

        $this->actingAs($user[1])
            ->post(route('post.link.request', $this->post))
            ->assertSessionHas(['message' => "Запрос отправлен {$this->post->owner->name}"]);
    }

    public function testUserCanRequestLinkToOwnerReply()
    {
        $user = factory(User::class, 2)->create();
        $reply = factory(Reply::class)->create(['post_id' => $this->post->id, 'owner_id' => 2]);

        $this->actingAs($user[0])
            ->post(route('reply.link.request', $reply))
            ->assertSessionHas(['message' => "Запрос отправлен {$reply->owner->name}"]);
    }
}