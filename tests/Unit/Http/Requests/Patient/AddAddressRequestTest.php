<?php

namespace Tests\Unit\Http\Requests\Patient;

use App\Http\Requests\Patient\AddAddressRequest;
use Tests\TestCase;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddAddressRequestTest extends TestCase
{
    public function test_valid_data_passes_validation()
    {
        $data = [
            'address' => [
                'street'      => '123 Main St',
                'city'        => 'Ciudad',
                'postal_code' => '12345'
            ],
            'gps' => [
                'latitude'  => 10.123,
                'longitude' => -20.456
            ]
        ];

        $request = AddAddressRequest::create('/api/v1/patient/1/address', 'POST', $data);

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
            'address' => [
                'city'        => 'Ciudad',
                'postal_code' => '12345'
            ],
        ];

        $request = AddAddressRequest::create('/api/v1/patient/1/address', 'POST', $data);
        $request->setContainer($this->app);
        $request->setRedirector(app('redirect'));

        $request->validateResolved();
    }
}
