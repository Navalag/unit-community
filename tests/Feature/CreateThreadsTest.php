<?php

namespace Tests\Feature;

use App\Activity;
use App\Rules\Recaptcha;
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

        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
             ->assertRedirect('/login');

        $this->post('/threads')
             ->assertRedirect('/login');
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
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
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

        $thread = create('App\Thread', ['title' => 'Foo Title 24', 'slug' => 'foo-title24']);

        $this->assertEquals($thread->fresh()->slug, 'foo-title24');

        $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);

        $this->assertTrue(Thread::whereSlug('foo-title24-2')->exists());

        $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);

        $this->assertTrue(Thread::whereSlug('foo-title24-3')->exists());
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }
}
