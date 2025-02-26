<?php

use App\Api\Http\Controllers\AppointmentController;
use App\Api\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('patient')->group(function () {
        Route::post('/', [PatientController::class, 'store']);
        Route::get('/', [PatientController::class, 'index']);
        Route::get('/{id}', [PatientController::class, 'show']);
        Route::put('/{id}', [PatientController::class, 'update']);
        Route::delete('/{id}', [PatientController::class, 'destroy']);

        Route::post('/{id}/address', [PatientController::class, 'createPatientAddress']);
        Route::post('/{id}/dietaryPreference', [PatientController::class, 'createPatientDietaryPreference']);
        Route::post('/{id}/measurement', [PatientController::class, 'createPatientMeasurement']);
        Route::post('/{id}/ticket', [PatientController::class, 'createPatientTicket']);
    });

    Route::prefix('appointment')->group(function () {

        Route::post('/', [AppointmentController::class, 'store']);
        Route::get('/', [AppointmentController::class, 'index']);

        Route::get('/by-nutritionist', [AppointmentController::class, 'getAppointmentsByNutritionistIdQuery']);

        Route::get('/{id}', [AppointmentController::class, 'show']);
        Route::put('/{id}', [AppointmentController::class, 'update']);
        Route::delete('/{id}', [AppointmentController::class, 'destroy']);
    });
});

