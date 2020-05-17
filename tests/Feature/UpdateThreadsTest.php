<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->refreshApplicationWithLocale('en');

        $this->withExceptionHandling();

        $this->signIn();
    }

    /** @test */
    function unauthorized_users_may_not_update_threads()
    {
        $thread = create(Thread::class, ['user_id' => create('App\User')->id]);

        $this->patch($thread->path(), [])->assertStatus(403);
    }

    /** @test */
    function a_thread_requires_a_title_and_body_to_be_updated()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed'
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(), [
            'body' => 'Changed'
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_can_be_updated_by_its_creator()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Changed',
            'body' => 'Changed body.'
        ]);

        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('Changed', $thread->title);

            $this->assertEquals('Changed body.', $thread->body);
        });
    }

    /** @test */
    function a_thread_tags_can_be_updated()
    {
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->patch($thread->path(), [
            'title' => 'Some title',
            'body' => 'Some body.',
            'tags' => 'Foo, Bar',
        ]);

        tap($thread->fresh(), function ($thread) {
            $tags = $thread->tags->pluck('name')->toArray();

            $this->assertContains('Foo', $tags);

            $this->assertContains('Bar', $tags);
        });
    }
}
