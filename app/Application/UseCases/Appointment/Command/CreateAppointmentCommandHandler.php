<?php

namespace App\Application\UseCases\Appointment\Command;

use App\Domain\Factories\AppointmentFactory;
use App\Domain\Repositories\AppointmentRepository;
use App\Shared\UnitOfWork;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateAppointmentCommandHandler
{
    private AppointmentRepository $appointmentRepository;
    private UnitOfWork $unitOfWork;

    /**
     * @param AppointmentRepository $appointmentRepository
     * @param UnitOfWork $unitOfWork
     */
    public function __construct(AppointmentRepository $appointmentRepository, UnitOfWork $unitOfWork)
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->unitOfWork = $unitOfWork;
    }


    public function handle(CreateAppointmentCommand $command): JsonResponse
    {
        $patientId = $command->getPatientId();
        $nutritionistId = $command->getNutritionistId();
        $reason = $command->getReason();

        $model = AppointmentFactory::create([
            'patient_id' => $patientId,
            'nutritionist_id' => $nutritionistId,
            'reason' => $reason
        ]);

        $appointmentModel = null;

        $this->unitOfWork->execute(function () use (&$model, &$appointmentModel) {
            $appointmentModel = $this->appointmentRepository->addAsync($model);
            $this->unitOfWork->addDomainEvents($model->getDomainEvents());
        });

        return response()->json([
            'data' => $appointmentModel
        ]);
    }
}
