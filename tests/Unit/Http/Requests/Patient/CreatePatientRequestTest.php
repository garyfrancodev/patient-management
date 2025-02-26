<?php

namespace Tests\Unit\Http\Requests\Patient;

use App\Http\Requests\Patient\CreatePatientRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class CreatePatientRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $data = [
            'user_id'   => '12345',
            'full_name' => [
                'first_name' => 'John',
                'last_name'  => 'Doe',
            ],
            'email'     => 'john.doe@example.com',
            'dni'       => 'A123456789',
            'phone'     => '123456789',
            'dob'       => '2000-05-15',
            'gender'    => 'male',
        ];

        $request = CreatePatientRequest::create('/api/v1/patient', 'POST', $data);

        $request->setContainer($this->app);
        $request->setRedirector(app('redirect'));

        $request->validateResolved();

        $validated = $request->validated();
        $this->assertEquals($data, $validated);
    }

    public function test_invalid_data_fails_validation()
    {
        $this->expectException(HttpResponseException::class);

        $data = [
            'user_id'   => '12345',
            'full_name' => [
                'first_name' => 'John'
            ],
            'email'     => 'john.doe@example.com',
            'dni'       => 'A123456789',
            'phone'     => '123456789',
            'dob'       => '2000-05-15',
            'gender'    => 'male',
        ];

        $request = CreatePatientRequest::create('/api/v1/patient', 'POST', $data);
        $request->setContainer($this->app);
        $request->setRedirector(app('redirect'));

        $request->validateResolved();
    }
}
