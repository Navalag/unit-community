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
            ->each(function ($entity) use ($event) {
                $entity->user->notify((new ThreadWasEdited(['user'=> $entity->user, 'thread' => $event->thread]))->locale($entity->user->locale));
            });
    }
}
