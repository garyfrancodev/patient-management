<?php

namespace Tests\Unit\Api\Http\Controllers;

use App\Api\Http\Controllers\AppointmentController;
use App\Application\UseCases\Appointment\Command\CreateAppointmentCommand;
use App\Application\UseCases\Appointment\Queries\GetAppointmentsByNutritionistIdQuery;
use App\Http\Requests\Appointment\CreateAppointmentRequest;
use App\Infrastructure\Core\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tests\TestCase;

class AppointmentControllerTest extends TestCase
{
    public function test_store_dispatches_createAppointmentCommand()
    {
        $data = [
            'nutritionist_id' => '12345',
            'patient_id'      => 'faeac40d-a9c0-4c4a-aa6b-ebb210afb589',
            'reason'          => 'catering',
        ];

        $createAppointmentRequest = $this->getMockBuilder(CreateAppointmentRequest::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['validated'])
            ->getMock();

        $createAppointmentRequest->expects($this->once())
            ->method('validated')
            ->willReturn($data);

        $expectedResponse = new JsonResponse(['result' => 'appointment created'], 201);

        $commandBusMock = $this->createMock(CommandBus::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($command) use ($data) {
                return $command instanceof CreateAppointmentCommand;
            }))
            ->willReturn($expectedResponse);

        $controller = new AppointmentController($commandBusMock);

        $actualResponse = $controller->store($createAppointmentRequest);

        $this->assertSame($expectedResponse, $actualResponse);
    }

    public function test_getAppointmentsByNutritionistIdQuery_dispatches_getAppointmentsByNutritionistIdQuery()
    {
        $nutritionistId = '12345';
        $request = new Request(['nutritionist_id' => $nutritionistId]);

        $expectedResponse = new JsonResponse(['appointments' => []], 200);

        $commandBusMock = $this->createMock(CommandBus::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($command) use ($nutritionistId) {
                return $command instanceof GetAppointmentsByNutritionistIdQuery;
            }))
            ->willReturn($expectedResponse);

        $controller = new AppointmentController($commandBusMock);

        $actualResponse = $controller->getAppointmentsByNutritionistIdQuery($request);

        $this->assertSame($expectedResponse, $actualResponse);
    }
}
