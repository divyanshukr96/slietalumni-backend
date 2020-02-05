<?php

namespace App\Notifications;

use App\AlumniMeet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class MeetConfirmation extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var AlumniMeet
     */
    private $alumniMeet;

    /**
     * Create a new notification instance.
     *
     * @param AlumniMeet $alumniMeet
     */
    public function __construct(AlumniMeet $alumniMeet)
    {
        //
        $this->alumniMeet = $alumniMeet;
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
        $year = date('Y');
        return (new MailMessage)
            ->subject(`SLIET Alumni Meet $year Confirmation`)
            ->replyTo('alumnicell@sliet.ac.in', 'SLIET Alumni Association')
            ->attach(public_path('/images/alumnimeet-2020-schedule.jpeg'), [
                'as' => (`SLIET Alumni Meet $year Schedule.jpeg`),
                'mime' => 'image/jpeg'
            ])
            ->attach(public_path('/images/alumnimeet-2020-star-night-schedule.jpeg'), [
                'as' => ('alumnimeet-2020-star-night-schedule.jpeg'),
                'mime' => 'image/jpeg'
            ])
            ->markdown('emails.meet.confirmation', ['data' => $this->alumniMeet, 'year' => $year]);
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
