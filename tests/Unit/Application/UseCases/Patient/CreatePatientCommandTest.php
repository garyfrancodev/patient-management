<?php

namespace Tests\Unit\Application\UseCases\Patient;

use App\Application\UseCases\Patient\Command\CreatePatientCommand;
use Carbon\Carbon;
use Tests\TestCase;

class CreatePatientCommandTest extends TestCase
{
    public function test_create_patient_command_stores_correct_data()
    {
        $dob = Carbon::createFromFormat('Y-m-d', '2000-05-15');
        $command = new CreatePatientCommand(
            $dob,
            'A123456789',
            'john.doe@example.com',
            ['first_name' => 'John', 'last_name' => 'Doe'],
            'male',
            '123456789',
            'user_123'
        );

        $this->assertEquals($dob, $command->getDob());
        $this->assertEquals('A123456789', $command->getDni());
        $this->assertEquals('john.doe@example.com', $command->getEmail());
        $this->assertEquals(['first_name' => 'John', 'last_name' => 'Doe'], $command->getFullName());
        $this->assertEquals('male', $command->getGender());
        $this->assertEquals('123456789', $command->getPhone());
        $this->assertEquals('user_123', $command->getUserId());
    }
}
