<?php

namespace Tests\Pact\Helper;

use Symfony\Component\Process\Process;

class PhpProcess
{
    private Process $process;
    private int $port;

    public function __construct(string $publicPath)
    {
        // Escoge un puerto aleatorio en el rango 8000-9000 (puedes ajustarlo)
        $this->port = 8000;
        // Inicia el servidor PHP integrado en la carpeta public
        $this->process = new Process(['php', '-S', "localhost:{$this->port}", '-t', $publicPath]);
    }

    public function start(): void
    {
        $this->process->start();
        // Espera unos segundos para que el servidor se levante
        sleep(1);
    }

    public function stop(): void
    {
        if ($this->process->isRunning()) {
            $this->process->stop();
        }
    }

    public function getPort(): int
    {
        return $this->port;
    }
}
