<?php

namespace App\Listeners;

use App\Events\ReplyReceivedBestMark;
use App\Notifications\ReplyWasMarkedAsBest;
use App\User;

class NotifyMarkedAsBestUsers
{
    /**
     * Handle the event.
     *
     * @param  ReplyReceivedBestMark  $event
     * @return void
     */
    public function handle(ReplyReceivedBestMark $event)
    {
        User::where('id', $event->reply->owner->id)
            ->where('id', '!=', $event->user->id)
            ->get()
            ->each(function (User $user) use ($event) {
                $user->notify((new ReplyWasMarkedAsBest(['user' => $event->user, 'reply' => $event->reply]))->locale($user->locale));
            });
    }
}
