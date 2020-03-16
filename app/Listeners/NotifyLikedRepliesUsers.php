<?php

namespace App\Listeners;

use App\Events\ReplyReceivedLike;
use App\Notifications\ReplyWasLiked;
use App\User;

class NotifyLikedRepliesUsers
{
    /**
     * Handle the event.
     *
     * @param  ReplyReceivedLike  $event
     * @return void
     */
    public function handle(ReplyReceivedLike $event)
    {
        User::whereIn('name', $event->reply->owner)
            ->where('id', '!=', $event->user->id)
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new ReplyWasLiked($event->reply, $event->user));
            });
    }
}
