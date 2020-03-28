<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ReplyWasEdited extends BaseNotification
{
    /**
     * Set the mail delivery channel.
     *
     * @return void
     */

    public function setChannels()
    {
        if ($this->data['user']->is_receive_thread_updates_mail) {
            array_push($this->channels, 'mail');
        }
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
            ->subject(trans('notifications.reply_was_edited.subject'))
            ->greeting($this->data['reply']->owner->name .  ' ' . trans('notifications.reply_was_edited.action') . ' ' . $this->data['reply']->thread->title)
            ->action(trans('notifications.button'), $this->data['reply']->path())
            ->line(trans('notifications.thanks_line'));
    }
}
