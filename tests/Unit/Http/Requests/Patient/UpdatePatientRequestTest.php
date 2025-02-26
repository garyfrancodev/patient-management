<?php

namespace Tests\Unit\Http\Requests\Patient;

use App\Http\Requests\Patient\UpdatePatientRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tests\TestCase;

class UpdatePatientRequestTest extends TestCase
{
    /**
     * Test que verifica que los datos válidos pasen la validación.
     */
    public function test_valid_data_passes_validation()
    {
        $data = [
            'user_id' => '12345',
            'full_name' => [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
            ],
            'email' => 'jane.doe@example.com',
            'dni' => 'B987654321',
            'phone' => '987654321',
            'dob' => '1990-12-31',
            'gender' => 'female'
        ];

        // Simula una petición PUT a la ruta deseada.
        $request = UpdatePatientRequest::create('/api/v1/patient/12345', 'PUT', $data);
        // Inyecta el contenedor y el redireccionador necesarios para la validación.
        $request->setContainer($this->app);
        $request->setRedirector(app('redirect'));

        // Ejecuta la validación.
        $request->validateResolved();

        // Obtén los datos validados y verifica que sean iguales a los enviados.
        $validated = $request->validated();
        $this->assertEquals($data, $validated);
    }

    /**
     * Test que verifica que los datos inválidos fallen la validación.
     */
    public function test_invalid_data_fails_validation()
    {
        $this->expectException(HttpResponseException::class);

        $data = [
            'user_id' => '12345',
            // Se envía un arreglo vacío para full_name, por lo que faltarán los campos 'first_name' y 'last_name'
            'full_name' => [],
            'email' => 'invalid-email', // Formato de email inválido.
            'dni' => 'B987654321',
            'phone' => '987654321',
            'dob' => 'not-a-date',      // Fecha en formato incorrecto.
            'gender' => 'unknown'          // Valor no permitido.
        ];

        $request = UpdatePatientRequest::create('/api/v1/patient/12345', 'PUT', $data);
        $request->setContainer($this->app);
        $request->setRedirector(app('redirect'));

        // Al ejecutar la validación se debe lanzar la excepción HttpResponseException.
        $request->validateResolved();
    }
}
