<?php

namespace App\Application\UseCases\Patient\Command;

class AddMeasurementCommand
{
    private string $patientId;
    private string $consultationId;
    private float $height;
    private float $weight;
    private float $bodyFlat;
    private string $notes;

    /**
     * @param string $patientId
     * @param string $consultationId
     * @param float $height
     * @param float $weight
     * @param float $bodyFlat
     * @param string $notes
     */
    public function __construct(string $patientId, string $consultationId, float $height, float $weight, float $bodyFlat, string $notes)
    {
        $this->patientId = $patientId;
        $this->consultationId = $consultationId;
        $this->height = $height;
        $this->weight = $weight;
        $this->bodyFlat = $bodyFlat;
        $this->notes = $notes;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getConsultationId(): string
    {
        return $this->consultationId;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getBodyFlat(): float
    {
        return $this->bodyFlat;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }
}
