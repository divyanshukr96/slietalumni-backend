<?php

namespace App\Observers;

use App\AlumniMeet;
use App\Notifications\MeetRegistration;

class AlumniMeetObserver
{
    /**
     * Handle the alumni meet "created" event.
     *
     * @param AlumniMeet $alumniMeet
     * @return void
     */
    public function created(AlumniMeet $alumniMeet)
    {
        $alumniMeet->notify(new MeetRegistration($alumniMeet));
    }

    /**
     * Handle the alumni meet "updated" event.
     *
     * @param AlumniMeet $alumniMeet
     * @return void
     */
    public function updated(AlumniMeet $alumniMeet)
    {
        //
    }

    /**
     * Handle the alumni meet "deleted" event.
     *
     * @param AlumniMeet $alumniMeet
     * @return void
     */
    public function deleted(AlumniMeet $alumniMeet)
    {
        //
    }

    /**
     * Handle the alumni meet "restored" event.
     *
     * @param AlumniMeet $alumniMeet
     * @return void
     */
    public function restored(AlumniMeet $alumniMeet)
    {
        //
    }

    /**
     * Handle the alumni meet "force deleted" event.
     *
     * @param AlumniMeet $alumniMeet
     * @return void
     */
    public function forceDeleted(AlumniMeet $alumniMeet)
    {
        //
    }
}
