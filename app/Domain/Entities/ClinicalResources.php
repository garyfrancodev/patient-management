<?php

namespace App\Domain\Entities;

use App\Shared\Entity;
use Carbon\Carbon;

class ClinicalResources extends Entity
{
    private string $patientId;

    private string $evaluationId;

    private string $nutritionistId;

    private string $typeResource;

    private string $description;

    private string $fileName;

    private string $path;

    private string $mimeType;

    private int $size;

    private Carbon $date;

    private Carbon $clinicalDate;

    private string $state;

    public function __construct(string $patientId, string $evaluationId, string $nutritionistId, string $typeResource, string $description, string $fileName, string $path, string $mimeType, int $size, Carbon $date, Carbon $clinicalDate, string $state, ?string $id = null)
    {
        parent::__construct($id);
        $this->nutritionistId = $nutritionistId;
        $this->evaluationId = $evaluationId;
        $this->typeResource = $typeResource;
        $this->clinicalDate = $clinicalDate;
        $this->description = $description;
        $this->patientId = $patientId;
        $this->fileName = $fileName;
        $this->mimeType = $mimeType;
        $this->state = $state;
        $this->path = $path;
        $this->size = $size;
        $this->date = $date;
    }
}
