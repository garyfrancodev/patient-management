<?php

namespace Features\Bootstrap;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private Client $client;
    private $response;
    private array $payload;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://localhost:8000']);
    }

    /**
     * @Given I have a valid patient payload:
     */
    public function iHaveAValidPatientPayload(TableNode $table)
    {
        $data = $table->getRowsHash();

        if (isset($data['full_name'])) {
            $data['full_name'] = json_decode($data['full_name'], true);
        }

        $this->payload = $data;
    }

    /**
     * @Given I have an invalid patient payload:
     */
    public function iHaveAnInvalidPatientPayload(TableNode $table)
    {
        $data = $table->getRowsHash();
        if (isset($data['full_name'])) {
            $data['full_name'] = json_decode($data['full_name'], true);
        }
        $this->payload = $data;
    }

    /**
     * @Given I have a valid appointment payload:
     */
    public function iHaveAValidAppointmentPayload(TableNode $table)
    {
        $this->payload = $table->getRowsHash();
    }

    /**
     * @Given I have an invalid appointment payload:
     */
    public function iHaveAnInvalidAppointmentPayload(TableNode $table)
    {
        $this->payload = $table->getRowsHash();
    }

    /**
     * @When I send a POST request to :path
     */
    public function iSendAPostRequestTo($path)
    {
        try {
            $this->response = $this->client->post($path, [
                'json' => $this->payload,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @Then the response status code should be :status
     */
    public function theResponseStatusCodeShouldBe($status)
    {
        Assert::assertEquals((int)$status, $this->response->getStatusCode());
    }
}
