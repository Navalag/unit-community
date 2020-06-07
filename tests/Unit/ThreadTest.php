<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ThreadWasUpdated;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @var Thread $thread */
    private $thread;

    public function setUp(): void
    {
        $this->refreshApplicationWithLocale('en');

        $this->thread = create(Thread::class);
    }

    /** @test */
    public function a_thread_has_a_path()
    {
        $thread = create(Thread::class);

        $this->assertEquals(
            url("/en/threads/{$thread->channel->slug}/{$thread->slug}"),
            $thread->path()
        );
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    function a_thread_can_have_a_best_reply()
    {
        $reply = $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->thread->markBestReply($reply);

        $this->assertEquals($reply->id, $this->thread->bestReply->id);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }

    /** @test */
    function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
                'body' => 'Foobar',
                'user_id' => create(User::class)->id
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $this->signIn();

        $this->thread->subscribe(auth()->id());

        $this->assertEquals(
            1,
            $this->thread->subscriptions()->where('user_id', auth()->id())->count()
        );
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        $this->thread->subscribe($userId = 1);

        $this->thread->unsubscribe($userId);

        $this->assertCount(0, $this->thread->subscriptions);
    }

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $this->signIn();

        $this->assertFalse($this->thread->isSubscribedTo);

        $this->thread->subscribe();

        $this->assertTrue($this->thread->isSubscribedTo);
    }

    /** @test */
    function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();

        tap(auth()->user(), function (User $user) {
            $this->assertTrue($this->thread->hasUpdatesFor($user));

            $user->read($this->thread);

            $this->assertFalse($this->thread->hasUpdatesFor($user));
        });
    }

    /** @test */
    public function a_thread_records_each_visit()
    {
        $this->thread->visits()->reset();

        $this->assertsame(0, $this->thread->visits()->count());

        $this->thread->visits()->record();

        $this->assertEquals(1, $this->thread->visits()->count());

        $this->thread->visits()->record();

        $this->assertEquals(2, $this->thread->visits()->count());
    }

    /** @test */
    function a_threads_body_is_sanitized_automatically()
    {
        $thread = make(Thread::class, ['body' => '<script>alert("bad")</script><p>This is okay.</p>']);

        $this->assertEquals("<p>This is okay.</p>", $thread->body);
    }
}
