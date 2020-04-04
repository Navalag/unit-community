<?php

namespace App\Events;

use App\Reply;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ReplyReceivedBestMark
{
    use Dispatchable;
    use SerializesModels;

    public $reply;

//    public $user;

    /**
     * Create a new event instance.
     *
     * @param Reply $reply
//     * @param User $user
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
//        $this->user = $user;
    }
}
