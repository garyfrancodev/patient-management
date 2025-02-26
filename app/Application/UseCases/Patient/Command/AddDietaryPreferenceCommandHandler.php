<?php

namespace App\Application\UseCases\Patient\Command;

use App\Domain\Factories\DietaryPreferenceFactory;
use App\Domain\Repositories\PatientRepository;
use App\Shared\UnitOfWork;
use Illuminate\Http\JsonResponse;

class AddDietaryPreferenceCommandHandler
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

    public function handle(AddDietaryPreferenceCommand $command): JsonResponse
    {
        $patientId = $command->getPatientId();
        $preference = $command->getPreference();

        $data = [
            "patient_id" => $patientId,
            "preference" => $preference,
        ];

        $address = DietaryPreferenceFactory::create($data);
        $model = null;

        $this->unitOfWork->execute(function () use (&$address, &$model) {
            $model = $this->patientRepository->createPatientDietaryPreference($address);

            $this->unitOfWork->addDomainEvents($address->getDomainEvents());
        });

        return response()->json(["data" => $model]);
    }
}
