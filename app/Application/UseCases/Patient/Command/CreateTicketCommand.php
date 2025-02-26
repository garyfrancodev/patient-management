<?php

namespace App\Application\UseCases\Patient\Command;

class CreateTicketCommand
{
    private string $details;
    private string $patientId;
    private string $type;

    /**
     * @param string $details
     * @param string $patientId
     * @param string $type
     */
    public function __construct(string $details, string $patientId, string $type)
    {
        $this->patientId = $patientId;
        $this->details = $details;
        $this->type = $type;
    }

    public function getDetails(): string
    {
        return $this->details;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
