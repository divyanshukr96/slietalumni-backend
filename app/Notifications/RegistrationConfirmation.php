<?php

namespace App\Notifications;

use App\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RegistrationConfirmation extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var Registration
     */
    private $alumni;
    private $token;

    /**
     * Create a new notification instance.
     *
     * @param Registration $registration
     * @param $token
     */
    public function __construct(Registration $registration, $token)
    {
        $this->alumni = $registration;
        $this->token = $token;
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
            ->markdown('emails.registration.Confirmation', ['name' => $name, 'token' => $this->token]);
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
            'user' => $this->alumni,
            'token' => $this->token,
            'verified_by' => auth()->user() ? auth()->user() : null,
        ];
    }
}
