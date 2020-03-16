<?php

namespace App\Http\Controllers;

use App\Events\ReplyReceivedBestMark;
use App\Reply;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class BestRepliesController extends Controller
{
    /**
     * Mark the best reply for a thread.
     *
     * @param  Reply $reply
     * @throws AuthorizationException
     */
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);
        $user = auth()->user();
        $reply->thread->markBestReply($reply, $user);
    }
}
