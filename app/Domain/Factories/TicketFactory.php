<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Ticket;

class TicketFactory
{
    public static function create($data): Ticket
    {
        $patientId = $data['patient_id'];
        $details = $data['details'];
        $type = $data['type'];
        $status = 'open';

        return new Ticket($details, $patientId, $status, $type);
    }
}
