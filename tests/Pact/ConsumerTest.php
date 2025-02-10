<?php

namespace Tests\Pact;

require_once __DIR__ . '/../../vendor/autoload.php';

use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;
use src\PersonConsumer;

class ConsumerTest extends TestCase
{
    /**
     * Example PACT test.
     *
     * @throws \Exception
     */
    public function testGetHelloString()
    {
        $id = "abc-123-def-456";
        $firstName = "Dade";
        $lastName = "Murphy";
        $alias = "Zero Cool";

        $request = new ConsumerRequest();
        $request->setMethod("GET")
            ->setPath("/person/" . $id)
            ->addHeader("Accept", "application/json");

        $response = new ProviderResponse();
        $response->setStatus(200)
            ->addHeader("Content-Type", "application/json")
            ->setBody(
                [
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "alias" => $alias,
                ]
            );

        $config = new MockServerEnvConfig();

        $builder = new InteractionBuilder($config);
        $builder
            ->uponReceiving('A get request to /hello/{name}')
            ->with($request)
            ->willRespondWith($response);

        $client = new Client(["base_uri" => $config->getBaseUri()]);
        $consumer = new PersonConsumer($client);

        $person = $consumer->getPersonById($id);

        $this->assertTrue($builder->verify());
    }
}
