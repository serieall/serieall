<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;


class ReplyContactNotification extends Notification
{
    use Queueable;

    protected $contact;
    protected $message;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct($contact, $message)
    {
        $this->contact = $contact;
        $this->message = $message;
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
        return (new MailMessage)
            ->success()
            ->greeting('Salut !')
            ->subject('Votre demande de contact')
            ->line($this->contact . ' vous a répondu :')
            ->line($this->message)
            ->salutation('A bientôt');
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
            //
        ];
    }
}
