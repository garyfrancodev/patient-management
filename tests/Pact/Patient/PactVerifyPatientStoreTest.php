<?php

namespace Tests\Pact\Patient;

use GuzzleHttp\Psr7\Uri;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use Tests\Pact\Helper\PhpProcess;
use Tests\TestCase;

class PactVerifyPatientStoreTest extends TestCase
{
    private PhpProcess $process;

    protected function setUp(): void
    {
        $publicPath = __DIR__ . '/../../public'; // Ajusta la ruta según tu proyecto
        $this->process = new PhpProcess($publicPath);
        $this->process->start();
    }

    protected function tearDown(): void
    {
        $this->process->stop();
    }

    public function testPactVerifyProvider(): void
    {
        $config = new VerifierConfig();

        $config->getProviderInfo()
            ->setName('LaravelPatientProvider')
            ->setHost('localhost')
            ->setPort($this->process->getPort());

        $config->getProviderState();
//            ->setStateChangeUrl(new Uri(sprintf('http://localhost:%d/pact-change-state', $this->process->getPort())));

        if ($logLevel = getenv('PACT_LOGLEVEL')) {
            $config->setLogLevel($logLevel);
        }

        $verifier = new Verifier($config);
        $verifier->addFile(__DIR__ . '/../../../pacts/LaravelPatientConsumer-LaravelPatientProvider.json');

        $verifyResult = $verifier->verify();

        $this->assertTrue($verifyResult);
    }
}
