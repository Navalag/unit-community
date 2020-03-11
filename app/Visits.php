<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    /**
     * Thread instance.
     *
     * @var Thread
     */
    protected $thread;

    /**
     * Visits constructor.
     *
     * @param Thread $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
     * Increment visits count for a given thread.
     *
     * @return $this
     */
    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    /**
     * Remove all visits count.
     *
     * @return $this
     */
    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    /**
     * Get visits count for a given thread.
     *
     * @return int
     */
    public function count()
    {
        $count = Redis::get($this->cacheKey());

        if ($count) {
            if ($count >= 1000000) {
                return round($count / 1000000, 1) . 'm';
            }
            else if ($count >= 1000) {
                return round($count / 1000, 1) . 'k';
            }
            return $count;
        }

        return 0;
    }

    /**
     * Get the cache key name.
     *
     * @return string
     */
    protected function cacheKey()
    {
        return app()->environment('testing')
            ? "testing.threads.{$this->thread->id}.visits"
            : "threads.{$this->thread->id}.visits";
    }
}
