<?php

namespace App\Domain\Aggregates;

use App\Domain\Events\CreatedAppointment;
use App\Domain\ValueObjects\ReasonVO;
use App\Shared\AggregateRoot;

class Appointment extends AggregateRoot
{
    private string $patientId;
    private string $nutritionistId;
    private ReasonVO $reasonVO;
    private string $status;

    /**
     * @param string $patientId
     * @param string $nutritionistId
     * @param ReasonVO $reasonVO
     * @param string $status
     */
    public function __construct(string $patientId, string $nutritionistId, ReasonVO $reasonVO, string $status, ?string $id = null)
    {
        parent::__construct($id);
        $this->patientId = $patientId;
        $this->nutritionistId = $nutritionistId;
        $this->reasonVO = $reasonVO;
        $this->status = $status;
        $this->addDomainEvent(new CreatedAppointment());
    }

    public function updateReason($reason) {
        $this->reasonVO = new ReasonVO($reason);
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getNutritionistId(): string
    {
        return $this->nutritionistId;
    }

    public function getReasonVO(): ReasonVO
    {
        return $this->reasonVO;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
