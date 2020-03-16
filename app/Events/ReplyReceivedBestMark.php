<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ReplyReceivedBestMark
{
    use Dispatchable, SerializesModels;

    public $reply;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($reply, $user)
    {
        $this->reply = $reply;
        $this->user = $user;
    }
}
