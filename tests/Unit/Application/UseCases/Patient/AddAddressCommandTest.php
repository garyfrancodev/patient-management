<?php

namespace Tests\Unit\Application\UseCases\Patient;

use App\Application\UseCases\Patient\Command\AddAddressCommand;
use Tests\TestCase;

class AddAddressCommandTest extends TestCase
{
    public function test_create_patient_command_stores_correct_data()
    {
        $address = [
            "street" => "Plan 3000",
            "city" => "Santa Cruz",
            "postal_code" => "591"
        ];
        $gps = [
            "latitude" => 40.753,
            "longitude" => -73.983
        ];
        $patientId = "faeac40d-a9c0-4c4a-aa6b-ebb210afb589";
        $command = new AddAddressCommand($address, $gps, $patientId);

        $this->assertEquals($address, $command->getAddress());
        $this->assertEquals($gps, $command->getGps());
        $this->assertEquals($patientId, $command->getPatientId());
    }
}
