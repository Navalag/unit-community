<?php

namespace App\Providers;

use App\Events\ReplyReceivedBestMark;
use App\Events\ReplyReceivedLike;
use App\Events\ReplyEdited;
use App\Events\ThreadEdited;
use App\Listeners\NotifyLikedRepliesUsers;
use App\Listeners\NotifyMarkedAsBestUsers;
use App\Listeners\NotifyReplyWasEdited;
use App\Listeners\NotifyThreadWasEdited;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ThreadReceivedNewReply;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\NotifySubscribers;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ThreadReceivedNewReply::class => [
            NotifyMentionedUsers::class,
            NotifySubscribers::class,
        ],
        ReplyReceivedLike::class => [
            NotifyLikedRepliesUsers::class,
        ],
        ReplyReceivedBestMark::class => [
            NotifyMarkedAsBestUsers::class,
        ],
        ReplyEdited::class => [
            NotifyReplyWasEdited::class,
        ],
        ThreadEdited::class => [
            NotifyThreadWasEdited::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
