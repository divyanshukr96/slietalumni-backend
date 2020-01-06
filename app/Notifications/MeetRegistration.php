<?php

namespace App\Notifications;

use App\AlumniMeet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MeetRegistration extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var AlumniMeet
     */
    private $alumni;

    /**
     * Create a new notification instance.
     *
     * @param AlumniMeet $alumniMeet
     */
    public function __construct(AlumniMeet $alumniMeet)
    {
        $this->alumni = $alumniMeet;
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
        $data = [
            'name' => $name,
            'coming' => $this->alumni->family ? 'Family' : 'Single',
            'amount' => $this->alumni->fees
        ];
        return (new MailMessage)
            ->subject(`SLIET Alumni Meet ${ date('Y') } Registration`)
            ->replyTo('alumnicell@sliet.ac.in', 'SLIET Alumni Association')
            ->markdown('emails.meet.success', ['data' => $data]);
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
