<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Rules\Recaptcha;
use App\Tag;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase, MockeryPHPUnitIntegration;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshApplicationWithLocale('en');

        $this->mock(Recaptcha::class, function ($m) {
            $m->shouldReceive('passes')->andReturn(true);
        });
    }

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get(route('threads.create'))
             ->assertRedirect(route('login'));

        $this->post(route('threads'))
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_create_new_forum_threads()
    {
        $response = $this->publishThread(['title' => 'Some Title', 'body' => 'Some body.']);

        $this->get($response->headers->get('Location'))
            ->assertSee('Some Title')
            ->assertSee('Some body.');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
             ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_can_have_tags()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $this->post(route('threads.store'), $thread->toArray() + [
            'tags' => 'foo',
            'g-recaptcha-response' => 'token',
        ]);

        $this->assertDatabaseHas('tags', ['name' => 'foo']);

        $this->assertContains('foo', Thread::first()->tags->pluck('name')->toArray());
    }

    /** @test */
    public function a_thread_can_have_no_more_than_3_tags()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $this->post(route('threads.store'), $thread->toArray() + [
                'tags' => 'foo, bar, baz, kek',
                'g-recaptcha-response' => 'token',
            ]);

        $this->assertDatabaseHas('tags', ['name' => 'foo']);
        $this->assertDatabaseHas('tags', ['name' => 'bar']);
        $this->assertDatabaseHas('tags', ['name' => 'baz']);
        $this->assertDatabaseMissing('tags', ['name' => 'kek']);

        $threadTags = Thread::first()->tags->pluck('name')->toArray();

        $this->assertContains('foo', $threadTags);
        $this->assertContains('bar', $threadTags);
        $this->assertContains('baz', $threadTags);
        $this->assertNotContains('kek', $threadTags);
    }

    /** @test */
    public function tags_cannot_be_duplicated()
    {
        $this->signIn();

        $this->post(route('threads.store'), make(Thread::class)->toArray() + [
            'tags' => 'Foo, Bar',
            'g-recaptcha-response' => 'token',
        ]);

        $this->post(route('threads.store'), make(Thread::class)->toArray() + [
            'tags' => 'Foo, Foo',
            'g-recaptcha-response' => 'token',
        ]);

        $this->assertCount(2, Tag::get());
    }

    /** @test */
    public function thread_can_have_one_tag_only_once()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $this->post(route('threads.store'), $thread->toArray() + [
            'tags' => 'Foo, Foo, Foo',
            'g-recaptcha-response' => 'token',
        ]);

        $this->assertCount(1, Thread::first()->tags);
    }

    /** @test */
    function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create(Thread::class, ['title' => 'Foo Title 24', 'slug' => 'foo-title-24']);

        $this->assertEquals($thread->fresh()->slug, 'foo-title-24');

        $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);

        $this->assertTrue(Thread::whereSlug('foo-title-24-2')->exists());

        $this->post(route('threads.store'), $thread->toArray() + ['g-recaptcha-response' => 'token']);

        $this->assertTrue(Thread::whereSlug('foo-title-24-3')->exists());
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);

        $this->delete($thread->path())->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_thread()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post(route('threads.store'), $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }
}
