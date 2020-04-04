<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ReplyWasMarkedAsBest extends BaseNotification
{
    /**
     * Set the mail delivery channel.
     *
     * @return void
     */

    public function setChannels()
    {
        if ($this->data['reply']->owner->is_receive_reply_reactions_mail) {
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
            ->subject(trans('notifications.reply_was_marked_as_best.subject'))
            ->greeting($this->data['reply']->thread->creator->name . ' ' . trans('notifications.reply_was_marked_as_best.action') . ' ' . $this->data['reply']->thread->title)
            ->action(trans('notifications.button'), $this->data['reply']->path())
            ->line(trans('notifications.thanks_line'));
    }
}
