<?php

namespace App\Application\UseCases\Patient\Command;

class AddDietaryPreferenceCommand
{
    private string $patientId;
    private string $preference;

    /**
     * @param string $patientId
     * @param string $preference
     */
    public function __construct(string $patientId, string $preference)
    {
        $this->patientId = $patientId;
        $this->preference = $preference;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getPreference(): string
    {
        return $this->preference;
    }
}
