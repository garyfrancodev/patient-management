<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Address;
use App\Domain\Entities\DietaryPreference;
use App\Domain\Entities\Measurement;
use App\Domain\Entities\Ticket;
use App\Shared\Repository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface PatientRepository extends Repository
{
    public function createPatientAddress(Address $entity): Model;

    public function createPatientDietaryPreference(DietaryPreference $entity): Model;

    /**
     * @param  DietaryPreference  $entity
     */
    public function createPatientMeasurement(Measurement $entity): Model;

    public function createPatientTicket(Ticket $entity): Model;

    public function getAllPatients(): Collection;
}
