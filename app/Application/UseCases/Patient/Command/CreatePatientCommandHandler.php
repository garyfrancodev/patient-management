<?php

namespace App\Application\UseCases\Patient\Command;

use App\Domain\Factories\PatientFactory;
use App\Domain\Repositories\PatientRepository;
use App\Shared\UnitOfWork;
use Illuminate\Http\JsonResponse;

class CreatePatientCommandHandler
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


    public function handle(CreatePatientCommand $command): JsonResponse
    {
        $data = [
            'user_id' => $command->getUserId(),
            'full_name' => $command->getFullName(),
            'email' => $command->getEmail(),
            'dni' => $command->getDni(),
            'dob' => $command->getDob(),
            'gender' => $command->getGender(),
            'phone' => $command->getPhone(),
        ];
        $patient = PatientFactory::create($data);
        $patientModel = null;

        $this->unitOfWork->execute(function () use (&$patient, &$patientModel) {
            $patientModel = $this->patientRepository->addAsync($patient);
            $this->unitOfWork->addDomainEvents($patient->getDomainEvents());
        });

        return response()->json(["data" => $patientModel]);
    }
}
