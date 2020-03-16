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
        User::whereIn('name', $event->reply->owner)
            ->where('id', '!=', $event->user->id)
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new ReplyWasMarkedAsBest($event->reply, $event->user));
            });
    }
}
