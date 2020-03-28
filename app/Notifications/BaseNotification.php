<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

abstract class BaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    protected $channels = ['database'];

    /**
     * Create a new notification instance.
     *
     * @param $data[]
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->setChannels();
    }

    /**
     * Setup mail delivery channel.
     *
     * @return void
     */
    abstract public function setChannels();

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     *
     */
    public function via($notifiable)
    {
        return $this->channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */

    abstract public function toMail($notifiable);

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->toMail($notifiable)->toArray();
    }
}
