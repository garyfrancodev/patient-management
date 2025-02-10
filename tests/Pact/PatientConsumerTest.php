<?php

namespace Tests\Pact;

use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;

class PatientConsumerTest
{
    /**
     * Test for Patient Consumer - Create patient
     */
    public function testCreatePatient()
    {
        $firstName = "Jane";
        $lastName = "Smith";
        $id = "54dffac6-34ff-40c3-bfab-ba20e3a2ce7d";

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
            ->given('Patient does not exist')
            ->uponReceiving('A POST request to /patient/')
            ->with($request)
            ->willRespondWith($response);

        $client = new Client(["base_uri" => $config->getBaseUri()]);

        $consumer = new PatientConsumer($client);
        $patient = $consumer->createPatient(['first_name' => $firstName, 'last_name' => $lastName]);

        $this->assertTrue($builder->verify());

        $this->assertEquals($id, $patient->getId());
        $this->assertEquals($firstName, $patient->getFirstName());
        $this->assertEquals($lastName, $patient->getLastName());
    }
}
