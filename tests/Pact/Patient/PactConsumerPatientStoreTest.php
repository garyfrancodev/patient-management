<?php

namespace Tests\Pact\Patient;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerConfig;
use Tests\TestCase;

class PactConsumerPatientStoreTest extends TestCase
{
    public function testPatientStoreConsumerContract(): void
    {
        $matcher = new Matcher();

        // Configura la solicitud esperada (ConsumerRequest)
        $consumerRequest = new ConsumerRequest();
        $consumerRequest->setMethod('POST')
            ->setPath('/api/v1/patient')
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'user_id'   => 'cb1231f8-4f77-4891-a405-e7d7d171fe8',
                'full_name' => ['first_name' => 'John', 'last_name' => 'Doe'],
                'email'     => 'john.doe@example.com',
                'dni'       => 'A123456789',
                'phone'     => '123456789',
                'dob'       => '2000-05-15',
                'gender'    => 'male',
            ]);

        $providerResponse = new ProviderResponse();
        $providerResponse->setStatus(201)
            ->addHeader('Content-Type', 'application/json')
            ->setBody([
                'id' => 'cb1231f8-4f77-4891-a405-e7d7d171fe0',
                'user_id'   => 'cb1231f8-4f77-4891-a405-e7d7d171fe8',
                'full_name' => ['first_name' => 'John', 'last_name' => 'Doe'],
                'email'     => 'john.doe@example.com',
                'dni'       => 'A123456789',
                'phone'     => '123456789',
                'dob'       => '2000-05-15',
                'gender'    => 'male',
            ]);

        // Configuración del servidor mock de Pact
        $config = new MockServerConfig();
        $config->setConsumer('LaravelPatientConsumer')
            ->setProvider('LaravelPatientProvider')
            ->setPactDir(base_path('pacts'));

        if ($logLevel = getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }

        $builder = new InteractionBuilder($config);
        $builder->uponReceiving('A request to create a new patient')
            ->with($consumerRequest)
            ->willRespondWith($providerResponse);

        // Obtiene la URL base del mock server
        $mockServerBaseUrl = $config->getBaseUri();

        $client = new Client([
            'base_uri' => "$mockServerBaseUrl",
            'headers'  => ['Content-Type' => 'application/json']
        ]);


        // Realiza la llamada HTTP contra el mock server utilizando el Http facade
        $response = $client->post('/api/v1/patient', [
            'json' => [
                'user_id'   => 'cb1231f8-4f77-4891-a405-e7d7d171fe8',
                'full_name' => ['first_name' => 'John', 'last_name' => 'Doe'],
                'email'     => 'john.doe@example.com',
                'dni'       => 'A123456789',
                'phone'     => '123456789',
                'dob'       => '2000-05-15',
                'gender'    => 'male',
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));

        $verifyResult = $builder->verify();
        $this->assertTrue($verifyResult);
    }
}
