<?php

namespace App\Notifications;

use App\Reply;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReplyWasLiked extends Notification
{
    use Queueable;

    protected $reply;

    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply, User $user)
    {
        $this->reply = $reply;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $url = $this->reply->path();

        return (new MailMessage)
            ->subject('Your reply was liked')
            ->action($this->user->name . ' liked your reply', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->user->name . ' liked your reply ' . $this->reply->thread->title,
            'link' => $this->reply->path()
        ];
    }
}
