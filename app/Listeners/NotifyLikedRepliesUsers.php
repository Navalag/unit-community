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
        User::where('id', $event->reply->owner->id)
            ->where('id', '!=', $event->user->id)
            ->get()
            ->each(function (User $user) use ($event) {
                $user->notify((new ReplyWasLiked(['user' => $event->user, 'reply' => $event->reply]))->locale($user->locale));
            });
    }
}
