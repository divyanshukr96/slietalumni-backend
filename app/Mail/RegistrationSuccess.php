<?php

namespace App\Mail;

use App\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationSuccess extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Registration
     */
    private $alumni;

    /**
     * Create a new message instance.
     *
     * @param Registration $registration
     */
    public function __construct(Registration $registration)
    {
        $this->alumni = $registration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = ucwords(strtolower($this->alumni->name));
        return $this->subject('SLIET Alumni Association Life Membership Registration')
            ->replyTo('association@slietalumni.com', 'SLIET Alumni Association')
            ->to($this->alumni->email, $name)
            ->markdown('emails.registration.success', ['name' => $name]);
    }
}
