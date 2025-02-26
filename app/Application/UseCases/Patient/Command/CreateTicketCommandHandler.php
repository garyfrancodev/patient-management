<?php

namespace App\Application\UseCases\Patient\Command;

use App\Domain\Factories\TicketFactory;
use App\Domain\Repositories\PatientRepository;
use App\Shared\UnitOfWork;
use Illuminate\Http\JsonResponse;

class CreateTicketCommandHandler
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

    public function handle(CreateTicketCommand $command): JsonResponse
    {
        $patientId = $command->getPatientId();
        $details = $command->getDetails();
        $type = $command->getType();


        $data = [
            'patient_id' => $patientId,
            'details' => $details,
            'type' => $type,
        ];

        $ticket = TicketFactory::create($data);
        $model = null;

        $this->unitOfWork->execute(function () use (&$ticket, &$model) {
            $model = $this->patientRepository->createPatientTicket($ticket);

            $this->unitOfWork->addDomainEvents($ticket->getDomainEvents());
        });

        return response()->json(["data" => $model]);
    }


}
