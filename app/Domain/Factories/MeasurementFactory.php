<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Measurement;

class MeasurementFactory
{
    public static function create($data): Measurement
    {
        $patientId = $data['patient_id'];
        $consultationId = $data['consultation_id'];
        $weight = $data['weight'];
        $height = $data['height'];
        $bodyFat = $data['body_fat'];
        $notes = $data['notes'];

        return new Measurement($patientId, $consultationId, $height, $weight, $bodyFat, $notes);
    }
}
