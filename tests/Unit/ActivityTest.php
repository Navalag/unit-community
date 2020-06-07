<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Activity;

class ActivityTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type'         => 'created_thread',
            'user_id'      => auth()->id(),
            'subject_id'   => $thread->id,
            'subject_type' => Thread::class,
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_record_an_activity_when_a_reply_is_created()
    {
        $this->signIn();

        create(Reply::class);

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create(Thread::class, ['user_id' => auth()->user()], 2);

        $feed = Activity::feed(auth()->user(), 50);

        $this->assertEquals($feed->first()->user_id, auth()->id());
        $this->assertCount(2, $feed);
    }
}
