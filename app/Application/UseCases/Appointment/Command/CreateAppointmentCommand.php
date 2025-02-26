<?php

namespace App\Application\UseCases\Appointment\Command;

class CreateAppointmentCommand
{
    private string $nutritionistId;
    private string $patientId;
    private string $reason;

    /**
     * @param string $nutritionistId
     * @param string $patientId
     * @param string $reason
     */
    public function __construct(string $nutritionistId, string $patientId, string $reason)
    {
        $this->nutritionistId = $nutritionistId;
        $this->patientId = $patientId;
        $this->reason = $reason;
    }

    public function getNutritionistId(): string
    {
        return $this->nutritionistId;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}
