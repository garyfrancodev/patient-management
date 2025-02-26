<?php

namespace Tests\Unit\Application\UseCases\Appointment;

use App\Application\UseCases\Appointment\Command\CreateAppointmentCommand;
use App\Application\UseCases\Appointment\Command\CreateAppointmentCommandHandler;
use App\Domain\Repositories\AppointmentRepository;
use App\Infrastructure\Persistence\Models\AppointmentModel;
use App\Shared\UnitOfWork;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class CreateAppointmentCommandHandlerTest extends TestCase
{
    public function test_handle_creates_appointment_and_returns_json_response()
    {
        $nutritionistId = "12345";
        $patientId = "54321";
        $reason = "catering";
        $command = new CreateAppointmentCommand($nutritionistId, $patientId, $reason);

        $appointmentModelMock = Mockery::mock(AppointmentModel::class);
        $appointmentData = [
            'id' => 1,
            'patient_id' => 'user_123',
            'nutritionist_id' => '12345',
            'reason' => 'catering'
        ];
        $appointmentModelMock->shouldReceive('toArray')->andReturn($appointmentData);
        $appointmentModelMock->shouldReceive('jsonSerialize')->andReturn($appointmentData);

        $mockRepository = Mockery::mock(AppointmentRepository::class);
        $mockUnitOfWork = Mockery::mock(UnitOfWork::class);

        $mockRepository->shouldReceive('addAsync')
            ->once()
            ->andReturn($appointmentModelMock);

        $mockUnitOfWork->shouldReceive('execute')
            ->once()
            ->andReturnUsing(function ($callback) use ($mockRepository) {
                return $callback();
            });

        $mockUnitOfWork->shouldReceive('addDomainEvents')
            ->once()
            ->andReturnNull();

        $handler = new CreateAppointmentCommandHandler($mockRepository, $mockUnitOfWork);
        $response = $handler->handle($command);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }
}
