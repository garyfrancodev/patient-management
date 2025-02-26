<?php

namespace Tests\Unit\Http\Requests\Appointment;

use App\Http\Requests\Appointment\CreateAppointmentRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class CreateAppointmentRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $data = [
            'reason' => 'Routine check-up',
            'nutritionist_id' => '12345',
            'patient_id' => '12345',
        ];

        $request = CreateAppointmentRequest::create('/api/v1/appointment', 'POST', $data);
        $request->setContainer($this->app);
        $request->setRedirector(app('redirect'));

        $request->validateResolved();

        $validated = $request->validated();
        $this->assertEquals($data, $validated);
    }

    /**
     * Verifica que los datos inválidos fallen la validación y lancen una excepción.
     */
    public function test_invalid_data_fails_validation()
    {
        $this->expectException(HttpResponseException::class);

        $data = [
            'reason' => 'Routine check-up',
            'nutritionist_id' => '12345'
        ];

        $request = CreateAppointmentRequest::create('/api/v1/appointment', 'POST', $data);
        $request->setContainer($this->app);
        $request->setRedirector(app('redirect'));

        $request->validateResolved();
    }
}
