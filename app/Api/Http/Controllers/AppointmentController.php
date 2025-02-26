<?php

namespace App\Api\Http\Controllers;

use App\Application\UseCases\Appointment\Command\CreateAppointmentCommand;
use App\Application\UseCases\Appointment\Queries\GetAppointmentsByNutritionistIdQuery;
use App\Http\Requests\Appointment\CreateAppointmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/appointment",
     *     tags={"Appointments"},
     *     summary="Create a new appointment",
     *     description="Handles the creation of a new appointment.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id"},
     *             @OA\Property(property="patient_id", type="string", example="faeac40d-a9c0-4c4a-aa6b-ebb210afb589", description="The user ID associated with the patient."),
     *             @OA\Property(property="nutritionist_id", type="string", format="string", example="12345"),
     *             @OA\Property(property="reason", type="string", example="catering", enum={"catering", "nutritional_advice"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PatientModel created successfully",
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
    public function store(CreateAppointmentRequest $createAppointmentRequest): JsonResponse
    {
        $data = $createAppointmentRequest->validated();
        $nutritionistId = $data['nutritionist_id'];
        $patientId = $data['patient_id'];
        $reason = $data['reason'];

        $command = new CreateAppointmentCommand($nutritionistId, $patientId, $reason);
        return $this->commandBus->dispatch($command);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/appointment/{id}",
     *     tags={"Appointments"},
     *     summary="Create a new appointment",
     *     description="Handles the creation of a new appointment.",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID del appointment",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="PatientModel created successfully",
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
    public function destroy(Request $request): JsonResponse {
        return response()->json();
    }

    public function getAppointmentsByNutritionistIdQuery(Request $request): JsonResponse
    {
        $id = $request->get('nutritionist_id');
        $command = new GetAppointmentsByNutritionistIdQuery($id);
        return $this->commandBus->dispatch($command);
    }
}
