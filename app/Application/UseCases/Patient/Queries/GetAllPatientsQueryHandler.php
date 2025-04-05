<?php

namespace App\Application\UseCases\Patient\Queries;

use App\Domain\Repositories\PatientRepository;
use Illuminate\Http\JsonResponse;

class GetAllPatientsQueryHandler
{
    private PatientRepository $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function handle(GetAllPatientsQuery $query): JsonResponse
    {
        $patients = $this->patientRepository->getAllPatients();

        return response()->json(['data' => $patients]);
    }
}
