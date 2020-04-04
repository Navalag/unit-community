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
        /** @var User $user */
        $user = User::find($event->reply->owner->id);

        $user->notify((new ReplyWasMarkedAsBest(['reply' => $event->reply]))->locale($user->locale));
    }
}
