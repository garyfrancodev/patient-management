<?php

namespace Tests\Unit\Application\UseCases\Patient;

use App\Application\UseCases\Patient\Command\CreatePatientCommand;
use App\Application\UseCases\Patient\Command\CreatePatientCommandHandler;
use App\Domain\Repositories\PatientRepository;
use App\Infrastructure\Persistence\Models\PatientModel;
use App\Shared\UnitOfWork;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class CreatePatientCommandHandlerTest extends TestCase
{
    public function test_handle_creates_patient_and_returns_json_response()
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

        // Creamos un mock de un modelo Eloquent en lugar de un array
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

        $mockRepository->shouldReceive('addAsync')
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

        $handler = new CreatePatientCommandHandler($mockRepository, $mockUnitOfWork);
        $response = $handler->handle($command);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }
}
