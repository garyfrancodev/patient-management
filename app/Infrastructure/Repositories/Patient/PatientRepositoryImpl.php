<?php

namespace App\Infrastructure\Repositories\Patient;

use App\Domain\Entities\Address;
use App\Domain\Entities\DietaryPreference;
use App\Domain\Entities\Measurement;
use App\Domain\Entities\Ticket;
use App\Domain\Repositories\PatientRepository;
use App\Infrastructure\Persistence\Models\AddressModel;
use App\Infrastructure\Persistence\Models\DietaryPreferenceModel;
use App\Infrastructure\Persistence\Models\MeasurementModel;
use App\Infrastructure\Persistence\Models\PatientModel;
use App\Infrastructure\Persistence\Models\TicketModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PatientRepositoryImpl implements PatientRepository
{
    public function getByIdAsync(string $id): Model
    {
        return PatientModel::find($id);
    }

    public function addAsync($entity): Model
    {
        $data = [
            'id' => $entity->getId(),
            'user_id' => $entity->getUserId(),
            'full_name' => $entity->getFullName()->getFullName(),
            'dob' => $entity->getDob()->getValue(),
            'gender' => $entity->getGender()->getValue(),
            'phone' => $entity->getPhone(),
            'dni' => $entity->getDni()->getDni(),
            'email' => $entity->getEmail()->getEmail()
        ];

        return PatientModel::create($data);
    }

    public function getAllPatients(): Collection
    {
        return PatientModel::all();
    }

    public function createPatientAddress(Address $entity): Model
    {
        $data = [
            'id' => $entity->getId(),
            'patient_id' => $entity->getPatientId(),
            'address' => $entity->getAddressVO()->getValue(),
            'gps' => $entity->getGpsVO()->toJson()
        ];

        return AddressModel::create($data);
    }

    public function createPatientDietaryPreference(DietaryPreference $entity): Model
    {
        $data = [
            'id' => $entity->getId(),
            'patient_id' => $entity->getPatientId(),
            'preference' => $entity->getPreference()
        ];

        return DietaryPreferenceModel::create($data);
    }

    public function createPatientMeasurement(Measurement $entity): Model
    {
        $data = [
            'id' => $entity->getId(),
            'patient_id' => $entity->getPatientId(),
            'consultation_id' => $entity->getConsultationId(),
            'height' => $entity->getHeight(),
            'weight' => $entity->getWeight(),
            'body_fat' => $entity->getBodyFat(),
            'notes' => $entity->getNotes(),
        ];

        return MeasurementModel::create($data);
    }

    public function createPatientTicket(Ticket $entity): Model
    {
        $data = [
            'id' => $entity->getId(),
            'patient_id' => $entity->getPatientId(),
            'type' => $entity->getType(),
            'details' => $entity->getDetails(),
            'status' => $entity->getStatus()
        ];

        return TicketModel::create($data);
    }
}
