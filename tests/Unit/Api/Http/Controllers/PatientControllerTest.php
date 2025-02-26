<?php

namespace Tests\Unit\Api\Http\Controllers;

use App\Api\Http\Controllers\PatientController;
use App\Application\UseCases\Patient\Command\AddAddressCommand;
use App\Application\UseCases\Patient\Command\AddDietaryPreferenceCommand;
use App\Application\UseCases\Patient\Command\AddMeasurementCommand;
use App\Application\UseCases\Patient\Command\CreatePatientCommand;
use App\Application\UseCases\Patient\Command\CreateTicketCommand;
use App\Application\UseCases\Patient\Queries\GetAllPatientsQuery;
use App\Http\Requests\Patient\AddAddressRequest;
use App\Http\Requests\Patient\AddDietaryPreferenceRequest;
use App\Http\Requests\Patient\AddMeasurementRequest;
use App\Http\Requests\Patient\CreatePatientRequest;
use App\Http\Requests\Patient\CreateTicketRequest;
use App\Infrastructure\Core\CommandBus;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    public function test_store_dispatches_createPatientCommand()
    {
        $data = [
            'user_id'   => '12345',
            'full_name' => ['first_name' => 'John', 'last_name' => 'Doe'],
            'email'     => 'john.doe@example.com',
            'dni'       => 'A123456789',
            'phone'     => '123456789',
            'dob'       => '2000-05-15',
            'gender'    => 'male'
        ];

        $createPatientRequest = $this->getMockBuilder(CreatePatientRequest::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['validated'])
            ->getMock();

        $createPatientRequest->expects($this->once())
            ->method('validated')
            ->willReturn($data);

        $expectedResponse = new JsonResponse(['result' => 'success'], 201);

        $commandBusMock = $this->createMock(CommandBus::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($command) use ($data) {
                if (!$command instanceof CreatePatientCommand) {
                    return false;
                }
                $expectedDob = Carbon::createFromFormat('Y-m-d', $data['dob']);
                return true;
            }))
            ->willReturn($expectedResponse);

        $controller = new PatientController($commandBusMock);

        $actualResponse = $controller->store($createPatientRequest);

        $this->assertSame($expectedResponse, $actualResponse);
    }

    public function test_index_dispatches_getAllPatientsQuery()
    {
        $expectedResponse = new JsonResponse(['patients' => []], 200);

        $commandBusMock = $this->createMock(CommandBus::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($command) {
                return $command instanceof GetAllPatientsQuery;
            }))
            ->willReturn($expectedResponse);

        $controller = new PatientController($commandBusMock);

        $actualResponse = $controller->index();

        $this->assertSame($expectedResponse, $actualResponse);
    }

    public function test_createPatientAddress_dispatches_addAddressCommand()
    {
        $data = [
            'address' => [
                'street'      => 'Plan 3000',
                'city'        => 'Santa Cruz',
                'postal_code' => '591',
            ],
            'gps' => [
                'latitude'  => 40.753,
                'longitude' => -73.983,
            ],
        ];

        $addAddressRequest = $this->createPartialMock(AddAddressRequest::class, ['validated', 'route']);

        $addAddressRequest->expects($this->once())
            ->method('validated')
            ->willReturn($data);

        $addAddressRequest->expects($this->once())
            ->method('route')
            ->with('id')
            ->willReturn('123');

        $expectedResponse = new JsonResponse(['result' => 'address created'], 201);

        $commandBusMock = $this->createMock(CommandBus::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($command) {
                return $command instanceof AddAddressCommand;
            }))
            ->willReturn($expectedResponse);

        $controller = new PatientController($commandBusMock);

        $actualResponse = $controller->createPatientAddress($addAddressRequest);

        $this->assertSame($expectedResponse, $actualResponse);
    }

    public function test_createPatientDietaryPreference_dispatches_addDietaryPreferenceCommand(): void
    {
        $data = [
            'preference' => 'Vegetarian'
        ];

        // Creamos un partial mock del request, simulando los métodos validated() y route()
        $addDietaryPreferenceRequest = $this->createPartialMock(AddDietaryPreferenceRequest::class, ['validated', 'route']);

        $addDietaryPreferenceRequest->expects($this->once())
            ->method('validated')
            ->willReturn($data);

        $addDietaryPreferenceRequest->expects($this->once())
            ->method('route')
            ->with('id')
            ->willReturn('123');

        $expectedResponse = new JsonResponse(['result' => 'preference added'], 201);

        // Creamos un mock del CommandBus para esperar el envío del comando correspondiente
        $commandBusMock = $this->createMock(CommandBus::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($command) {
                return $command instanceof AddDietaryPreferenceCommand
                    && $command->getPatientId() === '123'
                    && $command->getPreference() === 'Vegetarian';
            }))
            ->willReturn($expectedResponse);

        $controller = new PatientController($commandBusMock);

        $actualResponse = $controller->createPatientDietaryPreference($addDietaryPreferenceRequest);

        $this->assertSame($expectedResponse, $actualResponse);
    }

    public function test_createPatientMeasurement_dispatches_addMeasurementCommand(): void
    {
        $data = [
            'consultation_id' => 'cons-001',
            'height'          => 170,
            'weight'          => 65,
            'body_fat'        => 20,
            'notes'           => 'Measurement notes',
        ];

        // Creamos un partial mock del AddMeasurementRequest para simular los métodos validated() y route('id')
        $addMeasurementRequest = $this->createPartialMock(AddMeasurementRequest::class, ['validated', 'route']);

        $addMeasurementRequest->expects($this->once())
            ->method('validated')
            ->willReturn($data);

        $addMeasurementRequest->expects($this->once())
            ->method('route')
            ->with('id')
            ->willReturn('patient-123');

        $expectedResponse = new JsonResponse(['result' => 'measurement created'], 201);

        // Creamos un mock del CommandBus y esperamos que se despache un AddMeasurementCommand
        $commandBusMock = $this->createMock(CommandBus::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($command) {
                return $command instanceof AddMeasurementCommand;
            }))
            ->willReturn($expectedResponse);

        // Instanciamos el controlador inyectándole el mock del CommandBus
        $controller = new PatientController($commandBusMock);

        // Ejecutamos el método a testear
        $actualResponse = $controller->createPatientMeasurement($addMeasurementRequest);

        // Comprobamos que la respuesta es la esperada
        $this->assertSame($expectedResponse, $actualResponse);
    }

    public function test_createPatientTicket_dispatches_createTicketCommand(): void
    {
        $data = [
            'type'    => 'complaint',
            'details' => 'Ticket details info',
        ];

        // Creamos un partial mock del CreateTicketRequest para simular los métodos validated() y route('id')
        $createTicketRequest = $this->createPartialMock(CreateTicketRequest::class, ['validated', 'route']);
        $createTicketRequest->expects($this->once())
            ->method('validated')
            ->willReturn($data);
        $createTicketRequest->expects($this->once())
            ->method('route')
            ->with('id')
            ->willReturn('patient-321');

        // Configuramos la respuesta esperada del CommandBus
        $expectedResponse = new JsonResponse(['result' => 'ticket created'], 201);

        // Creamos un mock del CommandBus y esperamos que se despache un CreateTicketCommand
        $commandBusMock = $this->createMock(CommandBus::class);
        $commandBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function ($command) use ($data) {
                return $command instanceof CreateTicketCommand
                    && $command->getDetails() === $data['details']
                    && $command->getPatientId() === 'patient-321'
                    && $command->getType() === $data['type'];
            }))
            ->willReturn($expectedResponse);

        // Instanciamos el controlador inyectándole el mock del CommandBus
        $controller = new PatientController($commandBusMock);

        // Ejecutamos el método y comprobamos la respuesta
        $actualResponse = $controller->createPatientTicket($createTicketRequest);
        $this->assertSame($expectedResponse, $actualResponse);
    }
}
