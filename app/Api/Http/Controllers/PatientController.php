<?php

namespace App\Api\Http\Controllers;

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
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(title="My First API", version="0.1")
 */
class PatientController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/patient",
     *     tags={"Patients"},
     *     summary="Create a new patient",
     *     description="Handles the creation of a new patient.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id"},
     *             @OA\Property(property="user_id", type="string", example="12345", description="The user ID associated with the patient."),
     *             @OA\Property(property="full_name", type="object",
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe")
     *             ),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="dni", type="string", example="A123456789"),
     *             @OA\Property(property="phone", type="string", example="123456789"),
     *             @OA\Property(property="dob", type="string", format="date", example="2000-05-15"),
     *             @OA\Property(property="gender", type="string", example="male", enum={"male", "female", "other"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="string", example="12345"),
     *             @OA\Property(property="full_name", type="object",
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe")
     *             ),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */
    public function store(CreatePatientRequest $request): JsonResponse
    {
        error_log("hey bro");
        $data = $request->validated();

        $dob = Carbon::createFromFormat('Y-m-d', $data['dob']);
        $dni = $data['dni'];
        $email = $data['email'];
        $fullName = $data['full_name'];
        $gender = $data['gender'];
        $phone = $data['phone'];
        $userId = $data['user_id'];

        $command = new CreatePatientCommand($dob, $dni, $email, $fullName, $gender, $phone, $userId);

        return $this->commandBus->dispatch($command);
    }

    /**
     * Obtener todos los pacientes.
     *
     * @OA\Get(
     *     path="/api/patient",
     *     tags={"Patients"},
     *     summary="Obtiene todos los pacientes registrados.",
     *     description="Retorna una lista de pacientes.",
     *     operationId="getAllPatients",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de pacientes obtenida exitosamente.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="string", example="1"),
     *                 @OA\Property(property="fullName", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="email", type="string", example="juan.perez@email.com"),
     *                 @OA\Property(property="phone", type="string", example="+1234567890"),
     *                 @OA\Property(property="dob", type="string", format="date", example="1990-01-01"),
     *                 @OA\Property(property="gender", type="string", example="male"),
     *                 @OA\Property(property="dni", type="string", example="12345678"),
     *                 @OA\Property(property="userId", type="string", example="user_123"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud incorrecta",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor",
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $command = new GetAllPatientsQuery();
        return $this->commandBus->dispatch($command);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/patient/{id}/address",
     *     tags={"Patients"},
     *     summary="Create a new address for patient",
     *     description="Handles the creation of a new address.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="address", type="object",
     *                 @OA\Property(property="street", type="string", example="Plan 3000"),
     *                 @OA\Property(property="city", type="string", example="Santa Cruz"),
     *                 @OA\Property(property="postal_code", type="string", example="591")
     *             ),
     *             @OA\Property(property="gps", type="object",
     *                  @OA\Property(property="latitude", type="number", example="40.753"),
     *                  @OA\Property(property="longitude", type="number", example="-73.983")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PatientModel AddressModel created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="string", example="12345"),
     *             @OA\Property(property="full_name", type="object",
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe")
     *             ),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */
    public function createPatientAddress(AddAddressRequest $addAddressRequest): JsonResponse
    {
        $data = $addAddressRequest->validated();
        $address = $data['address'];
        $gps = $data['gps'];
        $patientId = $addAddressRequest->route('id');

        $command = new AddAddressCommand($address, $gps, $patientId);
        return $this->commandBus->dispatch($command);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/patient/{id}/dietaryPreference",
     *     tags={"Patients"},
     *     summary="Create a new address for patient",
     *     description="Handles the creation of a new address.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *           @OA\Property(property="preference", type="string", example="lacteos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PatientModel AddressModel created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="string", example="12345"),
     *             @OA\Property(property="full_name", type="object",
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe")
     *             ),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */
    public function createPatientDietaryPreference(AddDietaryPreferenceRequest $addDietaryPreferenceRequest): JsonResponse
    {
        $data = $addDietaryPreferenceRequest->validated();

        $patientId = $addDietaryPreferenceRequest->route('id');
        $preference = $data['preference'];

        $command = new AddDietaryPreferenceCommand($patientId, $preference);
        return $this->commandBus->dispatch($command);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/patient/{id}/measurement",
     *     tags={"Patients"},
     *     summary="Create a new address for patient",
     *     description="Handles the creation of a new address.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *           @OA\Property(property="consultation_id", type="string", example="123456"),
     *           @OA\Property(property="height", type="numeric", example="40.0"),
     *           @OA\Property(property="weight", type="numeric", example="30.0"),
     *           @OA\Property(property="body_fat", type="numeric", example="50.0"),
     *           @OA\Property(property="notes", type="string", example="this notes")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PatientModel AddressModel created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="string", example="12345"),
     *             @OA\Property(property="full_name", type="object",
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe")
     *             ),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */
    public function createPatientMeasurement(AddMeasurementRequest $addMeasurementRequest): JsonResponse
    {
        $data = $addMeasurementRequest->validated();
        $patientId = $addMeasurementRequest->route('id');
        $consultationId = $data['consultation_id'];
        $height = $data['height'];
        $weight = $data['weight'];
        $bodyFat = $data['body_fat'];
        $notes = $data['notes'];

        $command = new AddMeasurementCommand($patientId, $consultationId, $height, $weight, $bodyFat, $notes);
        return $this->commandBus->dispatch($command);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/patient/{id}/ticket",
     *     tags={"Patients"},
     *     summary="Create a new ticket",
     *     description="Handles the creation of a new address.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del paciente",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *           @OA\Property(property="type", type="string", example="support"),
     *           @OA\Property(property="details", type="string", example="test for ticket"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PatientModel AddressModel created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="string", example="12345"),
     *             @OA\Property(property="full_name", type="object",
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe")
     *             ),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input data"
     *     )
     * )
     */
    public function createPatientTicket(CreateTicketRequest $createTicketRequest): JsonResponse
    {
        $data = $createTicketRequest->validated();

        $patientId = $createTicketRequest->route('id');
        $type = $data['type'];
        $details = $data['details'];

        $command = new CreateTicketCommand($details, $patientId, $type);
        return $this->commandBus->dispatch($command);
    }
}
