<?php

namespace App\Domain\Entities;

use App\Shared\Entity;

class Ticket extends Entity
{
    private string $details;
    private string $patientId;
    private string $status;
    private string $type;

    /**
     * @param string $details
     * @param string $patientId
     * @param string $status
     * @param string $type
     */
    public function __construct(string $details, string $patientId, string $status, string $type, ?string $id = null)
    {
        parent::__construct($id);
        $this->details = $details;
        $this->patientId = $patientId;
        $this->status = $status;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
