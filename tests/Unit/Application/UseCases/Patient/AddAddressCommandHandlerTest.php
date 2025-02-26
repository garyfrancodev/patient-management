<?php

namespace Tests\Unit\Application\UseCases\Patient;

use App\Application\UseCases\Patient\Command\AddAddressCommand;
use App\Application\UseCases\Patient\Command\AddAddressCommandHandler;
use App\Application\UseCases\Patient\Command\CreatePatientCommand;
use App\Application\UseCases\Patient\Command\CreatePatientCommandHandler;
use App\Domain\Repositories\PatientRepository;
use App\Infrastructure\Persistence\Models\PatientModel;
use App\Shared\UnitOfWork;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Mockery;

class AddAddressCommandHandlerTest extends TestCase
{
    public function test_handle_creates_patient_and_returns_json_response()
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

        $patientModelMock = Mockery::mock(PatientModel::class);
        $patientData = [
            'id' => 1,
            'user_id' => 'user_123',
            'full_name' => ['first_name' => 'John', 'last_name' => 'Doe'],
            'email' => 'john.doe@example.com',
            'dni' => 'A123456789',
            'dob' => '2000-05-15',
            'gender' => 'male',
            'phone' => '123456789',
        ];
        $patientModelMock->shouldReceive('toArray')->andReturn($patientData);
        $patientModelMock->shouldReceive('jsonSerialize')->andReturn($patientData);

        $mockRepository = Mockery::mock(PatientRepository::class);
        $mockUnitOfWork = Mockery::mock(UnitOfWork::class);

        $mockRepository->shouldReceive('createPatientAddress')
            ->once()
            ->andReturn($patientModelMock);

        $mockUnitOfWork->shouldReceive('execute')
            ->once()
            ->andReturnUsing(function ($callback) use ($mockRepository) {
                return $callback();
            });

        $mockUnitOfWork->shouldReceive('addDomainEvents')
            ->once()
            ->andReturnNull();

        $handler = new AddAddressCommandHandler($mockRepository, $mockUnitOfWork);
        $response = $handler->handle($command);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }
}
