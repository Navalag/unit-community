<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ThreadEdited
{
    use Dispatchable,  SerializesModels;

    public $thread;

    /**
     * Create a new event instance.
     *
     * @param $reply
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

}
