<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Trending;

class TrendingThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @var Trending $trending */
    protected $trending;

    protected function setUp(): void
    {
        $this->refreshApplicationWithLocale('en');

        $this->trending = new Trending();

        $this->trending->reset();
    }

    /** @test */
    public function it_record_thread_in_trending_when_it_was_opened()
    {
        $this->assertEmpty($this->trending->get());

        $thread = create(Thread::class);

        $this->call('GET', $thread->path());

        $this->assertCount(1, $this->trending->get());
    }

    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_read()
    {
        $this->assertEmpty($this->trending->get());

        $thread = create(Thread::class);
        $thread2 = create(Thread::class);
        $thread3 = create(Thread::class);
        $thread4 = create(Thread::class);
        $thread5 = create(Thread::class);

        // hit 3 times
        $this->call('GET', $thread->path());
        $this->call('GET', $thread->path());
        $this->call('GET', $thread->path());

        // hit 2 times
        $this->call('GET', $thread2->path());
        $this->call('GET', $thread2->path());

        // hit each 1 time
        $this->call('GET', $thread3->path());
        $this->call('GET', $thread4->path());
        $this->call('GET', $thread5->path());

        $trending = $this->trending->get();

        $this->assertEquals($thread->id, array_shift($trending));
        $this->assertEquals($thread2->id, array_shift($trending));
        $this->assertEquals($thread5->id, array_shift($trending));
    }
}
