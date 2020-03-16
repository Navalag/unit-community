<?php

namespace App\Listeners;

use App\Events\ReplyEdited;
use App\Notifications\ReplyWasEdited;

class NotifyReplyWasEdited
{
    /**
     * Handle the event.
     *
     * @param  ReplyEdited  $event
     * @return void
     */
    public function handle(ReplyEdited $event)
    {
        $event->reply->thread->subscriptions
            ->where('user_id', '!=', $event->reply->user_id)
            ->each(function ($user) use ($event) {
                $user->user->notify(new ReplyWasEdited($event->reply));
            });
    }
}
