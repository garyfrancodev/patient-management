<?php

namespace Tests\Pact\Appontment;

use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use Tests\TestCase;

class AppointmentConsumerTest extends TestCase
{
    /**
     * Test para la solicitud GET /appointment/{id}
     */
    public function testGetAppointmentById()
    {
        $id = "54dffac6-34ff-40c3-bfab-ba20e3a2ce7d";
        $patientName = "John Doe";
        $appointmentDate = "2025-02-10";

        $request = new ConsumerRequest();
        $request->setMethod("GET")
            ->setPath("/appointment/" . $id)
            ->addHeader("Accept", "application/json");

        $response = new ProviderResponse();
        $response->setStatus(200)
            ->addHeader("Content-Type", "application/json")
            ->setBody([
                "id" => $id,
                "patient_name" => $patientName,
                "appointment_date" => $appointmentDate
            ]);

        $config = new MockServerEnvConfig();

        $builder = new InteractionBuilder($config);
        $builder
            ->given('AppointmentModel exists with id ' . $id)
            ->uponReceiving('A GET request to /appointment/{id}')
            ->with($request)
            ->willRespondWith($response);

        $client = new Client(["base_uri" => $config->getBaseUri()]);
        $response = $client->request('GET', "/appointment/{$id}");

        $this->assertTrue($builder->verify());

        $data = json_decode($response->getBody()->getContents());
        $this->assertEquals($patientName, $data->patient_name);
        $this->assertEquals($appointmentDate, $data->appointment_date);
    }

    /**
     * Test para la solicitud POST /patient/
     */
    public function testCreatePatient()
    {
        $firstName = "Jane";
        $lastName = "Smith";
        $id = "abc-123-def-456";

        $request = new ConsumerRequest();
        $request->setMethod("POST")
            ->setPath("/patient/")
            ->addHeader("Content-Type", "application/json")
            ->setBody([
                'first_name' => $firstName,
                'last_name' => $lastName
            ]);

        $response = new ProviderResponse();
        $response->setStatus(201)
            ->addHeader("Content-Type", "application/json")
            ->setBody([
                'id' => $id,
                'first_name' => $firstName,
                'last_name' => $lastName
            ]);
        $config = new MockServerEnvConfig();

        $builder = new InteractionBuilder($config);
        $builder
            ->given('PatientModel does not exist')
            ->uponReceiving('A POST request to /patient/')
            ->with($request)
            ->willRespondWith($response);

        $client = new Client(["base_uri" => $config->getBaseUri()]);
        $response = $client->request('POST', "/patient/", [
            'json' => [
                'first_name' => $firstName,
                'last_name' => $lastName
            ]
        ]);

        $this->assertTrue($builder->verify());

        $data = json_decode($response->getBody()->getContents());
        $this->assertEquals($id, $data->id);
        $this->assertEquals($firstName, $data->first_name);
        $this->assertEquals($lastName, $data->last_name);
    }
}
