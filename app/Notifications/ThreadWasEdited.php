<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ThreadWasEdited extends BaseNotification
{
    /**
     * Set the mail delivery channel.
     * @return void
     */

    public function setChannels()
    {
        if ($this->data['user']->is_receive_thread_updates_mail) {
            array_push($this->channels, 'mail');
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('notifications.thread_was_edited.subject'))
            ->greeting($this->data['thread']->creator->name . ' ' . trans('notifications.thread_was_edited.action') . ' ' . $this->data['thread']->title)
            ->action(trans('notifications.button'), $this->data['thread']->path())
            ->line(trans('notifications.thanks_line'));
    }
}
