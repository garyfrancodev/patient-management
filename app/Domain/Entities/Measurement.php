<?php

namespace App\Domain\Entities;

use App\Shared\AggregateRoot;
use App\Shared\Entity;

class Measurement extends Entity
{
    private string $patientId;
    private ?string $consultationId;
    private string $height;
    private string $weight;
    private string $bodyFat;
    private string $notes;

    /**
     * @param string $patientId
     * @param ?string $consultationId
     * @param string $height
     * @param string $weight
     * @param string $bodyFat
     * @param string $notes
     */
    public function __construct(string $patientId, ?string $consultationId, string $height, string $weight, string $bodyFat, string $notes, ?string $id = null)
    {
        parent::__construct($id);
        $this->consultationId = $consultationId;
        $this->patientId = $patientId;
        $this->bodyFat = $bodyFat;
        $this->height = $height;
        $this->weight = $weight;
        $this->notes = $notes;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getConsultationId(): ?string
    {
        return $this->consultationId;
    }

    public function getHeight(): string
    {
        return $this->height;
    }

    public function getWeight(): string
    {
        return $this->weight;
    }

    public function getBodyFat(): string
    {
        return $this->bodyFat;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }
}
