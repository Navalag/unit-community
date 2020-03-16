<?php

namespace App\Listeners;

use App\Notifications\ThreadWasEdited;

class NotifyThreadWasEdited
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->thread->subscriptions
            ->where('user_id', '!=', $event->thread->user_id)
            ->each(function ($user) use ($event) {
                $user->user->notify(new ThreadWasEdited($event->thread));
            });
    }
}
