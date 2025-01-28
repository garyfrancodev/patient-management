<?php

namespace Tests\Unit\Application\UseCases\Appointment\Command;

use App\Application\UseCases\Appointment\Command\CreateAppointmentCommand;
use App\Application\UseCases\Appointment\Command\CreateAppointmentCommandHandler;
use App\Domain\Factories\AppointmentFactory;
use App\Domain\Repositories\AppointmentRepository;
use App\Infrastructure\Http\Requests\Appointment\CreateAppointmentRequest;
use PHPUnit\Framework\TestCase;

class CreateAppointmentCommandHandlerTest extends TestCase
{
    public function test_handle_creates_appointment()
    {
        // 1. Mock del repositorio
        $mockRepository = $this->createMock(AppointmentRepository::class);

        // 2. Mock de AppointmentFactory
        $mockModel = $this->createMock(\App\Domain\Aggregates\Appointment::class);

        // Simular el modelo devuelto por el factory
        $mockModel->method('getId')->willReturn('1234');

        // 3. Crear el handler con el repositorio mockeado
        $handler = new CreateAppointmentCommandHandler($mockRepository);

        // 4. Mock de CreateAppointmentRequest
        $mockRequest = $this->createMock(CreateAppointmentRequest::class);

        // 5. Crear el comando con el request mockeado
        $command = new CreateAppointmentCommand($mockRequest);

        // 6. Ejecutar el método handle
        $response = $handler->handle($command);

        // 7. Verificar la respuesta
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['data' => '1234'], $response->getData(true));
    }
}
