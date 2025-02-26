<?php

namespace App\Domain\Factories;

use App\Domain\Aggregates\Appointment;
use App\Domain\Aggregates\Patient;
use App\Domain\ValueObjects\ReasonVO;

class AppointmentFactory
{
    public static function create(array $data): Appointment {
        $patientId = $data['patient_id'];
        $nutritionistId = $data['nutritionist_id'];
        $reason = $data['reason'];
        $reasonVO = new ReasonVO($reason);
        $status = 'pending';

        return new Appointment($patientId, $nutritionistId, $reasonVO, $status);
    }

}
