<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class ContactRequest extends Notification
{
    use Queueable;

    protected $name;
    protected $email;
    protected $objet;
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param $name
     * @param $email
     * @param $objet
     * @param $message
     */
    public function __construct($name, $email, $objet, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->objet = $objet;
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
            ->subject(" Demande de contact : " . $this->objet)
            ->from($address = "bmayelle@hotmail.fr", $name = $this->name)
            ->line($this->name . ' a créé une demande de contact : ')
            ->line($this->message)
            ->salutation("Kiffe et paillettes.");
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
