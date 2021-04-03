<?php

namespace App\Notifications;

use App\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RegistrationSuccess extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var Registration
     */
    private $alumni;

    /**
     * Create a new notification instance.
     *
     * @param Registration $registration
     */
    public function __construct(Registration $registration)
    {
        $this->alumni = $registration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $name = ucwords(strtolower($this->alumni->name));
        return (new MailMessage)
            ->subject('SLIET Alumni Association Life Membership Registration')
            ->replyTo('association@slietalumni.org', 'SLIET Alumni Association')
            ->markdown('emails.registration.success', ['name' => $name]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
