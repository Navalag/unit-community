<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ThreadEdited
{
    use Dispatchable;
    use SerializesModels;

    public $thread;

    /**
     * Create a new event instance.
     *
     * @param $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }
}
