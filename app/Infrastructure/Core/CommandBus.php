<?php

namespace App\Infrastructure\Core;

class CommandBus
{
    private array $handlers = [];

    /**
     * Register a handler for a specific command.
     */
    public function register(string $command, object $handler): void
    {
        $this->handlers[$command] = $handler;
    }

    /**
     * Dispatch a command to its handler.
     */
    public function dispatch(object $command): mixed
    {
        $commandClass = get_class($command);

        if (! isset($this->handlers[$commandClass])) {
            throw new \Exception("No handler registered for command: {$commandClass}");
        }

        $handler = $this->handlers[$commandClass];

        if (! method_exists($handler, 'handle')) {
            throw new \Exception("Handler for command {$commandClass} must have a handle method.");
        }

        return $handler->handle($command);
    }
}
