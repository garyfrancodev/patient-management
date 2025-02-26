<?php

namespace App\Domain\Entities;

use App\Shared\Entity;

class DietaryPreference extends Entity
{
    private string $patientId;
    private string $preference;

    /**
     * @param string $patientId
     * @param string $preference
     * @param ?string $id
     */
    public function __construct(string $patientId, string $preference, ?string $id = null)
    {
        parent::__construct($id);
        $this->patientId = $patientId;
        $this->preference = $preference;
    }

    public function updatePreference($newValue)
    {
        $this->preference = $newValue;
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
