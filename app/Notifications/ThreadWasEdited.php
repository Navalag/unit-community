<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ThreadWasEdited extends Notification
{
    use Queueable;
    protected $thread;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
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
        $url = $this->thread->path();

        return (new MailMessage)
            ->subject('Thread was edited')
            ->action($this->thread->creator->name . ' has edited thread at ' . $this->thread->title, $url)
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
            'message' => $this->thread->creator->name . ' has edited thread at ' . $this->thread->title,
            'link'    => $this->thread->path()
        ];
    }
}
