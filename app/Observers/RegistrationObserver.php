<?php

namespace App\Observers;

use App\Notifications\RegistrationSuccess;
use App\Registration;

class RegistrationObserver
{
    /**
     * Handle the registration "created" event.
     *
     * @param Registration $registration
     * @return void
     */
    public function created(Registration $registration)
    {
        $registration->notify(new RegistrationSuccess($registration));
    }

    /**
     * Handle the registration "updated" event.
     *
     * @param Registration $registration
     * @return void
     */
    public function updated(Registration $registration)
    {
        //
    }

    /**
     * Handle the registration "deleted" event.
     *
     * @param Registration $registration
     * @return void
     */
    public function deleted(Registration $registration)
    {
        //
    }

    /**
     * Handle the registration "restored" event.
     *
     * @param Registration $registration
     * @return void
     */
    public function restored(Registration $registration)
    {
        //
    }

    /**
     * Handle the registration "force deleted" event.
     *
     * @param Registration $registration
     * @return void
     */
    public function forceDeleted(Registration $registration)
    {
        //
    }
}
