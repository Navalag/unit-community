<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class VerifyEmailChange extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    protected $user;

    /**
     * var email
     */
    protected $email;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param $email
     */
    public function __construct(User $user, $email)
    {
        $this->user = $user;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('emailverification', [
            'user' => $this->user->name,
            'id' => $this->user->id,
            'token' => md5($this->user->email),
            'email' => $this->email
        ]);

        return (new MailMessage)
            ->subject(trans('notifications.verify_email_change.subject'))
            ->line(trans('notifications.verify_email_change.line'))
            ->action(trans('notifications.verify_email_change.action'), $url)
            ->line(trans('notifications.thanks_line'));
    }
}
