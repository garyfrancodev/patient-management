<?php

namespace App\Application\UseCases\Patient\Command;

use App\Domain\Factories\AddressFactory;
use App\Domain\Repositories\PatientRepository;
use App\Shared\UnitOfWork;
use Illuminate\Http\JsonResponse;

class AddAddressCommandHandler
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


    public function handle(AddAddressCommand $command): JsonResponse
    {
        $data = [
            "patient_id" => $command->getPatientId(),
            "address" => $command->getAddress(),
            "gps" => $command->getGps()
        ];

        $address = AddressFactory::create($data);
        $model = null;

        $this->unitOfWork->execute(function () use (&$address, &$model) {
            $model = $this->patientRepository->createPatientAddress($address);

            $this->unitOfWork->addDomainEvents($address->getDomainEvents());
        });

        return response()->json(["data" => $model]);
    }
}
