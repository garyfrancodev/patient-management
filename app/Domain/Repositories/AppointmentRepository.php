<?php

namespace App\Domain\Repositories;

use App\Shared\Repository;

interface AppointmentRepository extends Repository
{
    public function getAppointmentsByNutritionistId($id);
}
