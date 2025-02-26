<?php

namespace Tests\Unit\Application\UseCases\Appointment;

use App\Application\UseCases\Appointment\Command\CreateAppointmentCommand;
use Tests\TestCase;

class CreateAppointmentCommandTest extends TestCase
{
    public function test_create_appointment_command_stores_correct_data()
    {
        $nutritionistId = "12345";
        $patientId = "54321";
        $reason = "catering";
        $command = new CreateAppointmentCommand($nutritionistId, $patientId, $reason);

        $this->assertEquals($nutritionistId, $command->getNutritionistId());
        $this->assertEquals($patientId, $command->getPatientId());
        $this->assertEquals($reason, $command->getReason());
    }
}
