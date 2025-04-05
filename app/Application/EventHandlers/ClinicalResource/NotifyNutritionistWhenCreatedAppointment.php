<?php

namespace App\Application\EventHandlers\ClinicalResource;

use App\Domain\Events\CreatedAppointment;

class NotifyNutritionistWhenCreatedAppointment
{
    /**
     * Handle the event.
     */
    public function handle(CreatedAppointment $event)
    {
        error_log('Listener ejecutado: CreatedAppointment');
        // TODO: send email
    }
}
