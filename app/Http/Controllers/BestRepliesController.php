<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Auth\Access\AuthorizationException;

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
        $reply->thread->markBestReply($reply, auth()->user());
    }
}
