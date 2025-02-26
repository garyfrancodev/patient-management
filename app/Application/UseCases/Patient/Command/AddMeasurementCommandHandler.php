<?php

namespace App\Application\UseCases\Patient\Command;

use App\Domain\Factories\MeasurementFactory;
use App\Domain\Repositories\PatientRepository;
use App\Shared\UnitOfWork;
use Illuminate\Http\JsonResponse;

class AddMeasurementCommandHandler
{
    private PatientRepository $patientRepository;
    private UnitOfWork $unitOfWork;

    /**
     * @param PatientRepository $patientRepository
     * @param UnitOfWork $unitOfWork
     */
    public function __construct(PatientRepository $patientRepository, UnitOfWork $unitOfWork)
    {
        $this->patientRepository = $patientRepository;
        $this->unitOfWork = $unitOfWork;
    }

    public function handle(AddMeasurementCommand $addMeasurementCommand): JsonResponse {
        $patientId = $addMeasurementCommand->getPatientId();
        $consultationId = $addMeasurementCommand->getConsultationId();
        $height = $addMeasurementCommand->getHeight();
        $weight = $addMeasurementCommand->getWeight();
        $bodyFat = $addMeasurementCommand->getBodyFlat();
        $notes = $addMeasurementCommand->getNotes();

        $data = [
            'patient_id' => $patientId,
            'consultation_id' => $consultationId,
            'height' => $height,
            'weight' => $weight,
            'body_fat' => $bodyFat,
            'notes' => $notes
        ];


        $measurement = MeasurementFactory::create($data);

        $model = null;

        $this->unitOfWork->execute(function () use (&$measurement, &$model) {
            $model = $this->patientRepository->createPatientMeasurement($measurement);

            $this->unitOfWork->addDomainEvents($measurement->getDomainEvents());
        });

        return response()->json(["data" => $model]);
    }


}
