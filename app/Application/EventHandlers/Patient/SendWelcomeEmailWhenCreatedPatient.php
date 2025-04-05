<?php

namespace App\Application\EventHandlers\Patient;

use App\Domain\Events\PatientCreated;

class SendWelcomeEmailWhenCreatedPatient
{
    public function handle(PatientCreated $event)
    {
        error_log('handler PatientCreated');
        error_log('send email');
        error_log($event->getEmail());
    }
}
