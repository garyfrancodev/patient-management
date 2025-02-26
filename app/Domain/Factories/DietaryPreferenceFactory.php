<?php

namespace App\Domain\Factories;

use App\Domain\Entities\DietaryPreference;

class DietaryPreferenceFactory
{
    public static function create($data): DietaryPreference
    {
        $patientId = $data['patient_id'];
        $preference = $data['preference'];

        return new DietaryPreference($patientId, $preference);
    }
}
