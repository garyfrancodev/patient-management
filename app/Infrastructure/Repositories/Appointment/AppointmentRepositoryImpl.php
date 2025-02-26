<?php

namespace App\Infrastructure\Repositories\Appointment;

use App\Domain\Repositories\AppointmentRepository;
use App\Infrastructure\Persistence\Models\AppointmentModel;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Aggregates\Appointment as AppointmentDomain;
use Illuminate\Support\Collection;

class AppointmentRepositoryImpl implements AppointmentRepository
{

    public function getByIdAsync(string $id): Model
    {
        return AppointmentModel::find($id);
    }

    /**
     * @param AppointmentDomain $entity
     */
    public function addAsync($entity): Model
    {
        $data = [
            'id' => $entity->getId(),
            'patient_id' => $entity->getPatientId(),
            'nutritionist_id' => $entity->getNutritionistId(),
            'reason' => $entity->getReasonVO()->getValue(),
            'status' => $entity->getStatus()
        ];

        return AppointmentModel::create($data);
    }

    public function getAppointmentsByNutritionistId($id): Collection
    {
        return AppointmentModel::where('nutritionist_id', $id)->get();
    }
}
