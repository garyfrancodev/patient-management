<?php

namespace Tests\Unit\Infrastructure\Core;

use App\Infrastructure\Core\CommandBus;
use Tests\TestCase;

class DummyCommand {}

class DummyHandler {
    public function handle($command): string {
        return "handled";
    }
}

class InvalidHandler {}

class CommandBusTest extends TestCase
{
    /**
     * Verifica que al despachar un comando con un handler registrado se retorne el resultado esperado.
     */
    public function test_dispatch_returns_handler_result()
    {
        $bus = new CommandBus();
        $command = new DummyCommand();
        $handler = new DummyHandler();

        $bus->register(DummyCommand::class, $handler);

        $result = $bus->dispatch($command);
        $this->assertEquals("handled", $result);
    }

    /**
     * Verifica que se lance una excepción si se intenta despachar un comando sin un handler registrado.
     */
    public function test_dispatch_throws_exception_when_handler_not_registered()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("No handler registered for command: " . DummyCommand::class);

        $bus = new CommandBus();
        $command = new DummyCommand();

        $bus->dispatch($command);
    }

    /**
     * Verifica que se lance una excepción si el handler registrado no tiene el método "handle".
     */
    public function test_dispatch_throws_exception_when_handler_has_no_handle_method()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Handler for command " . DummyCommand::class . " must have a handle method.");

        $bus = new CommandBus();
        $command = new DummyCommand();
        $invalidHandler = new InvalidHandler();

        $bus->register(DummyCommand::class, $invalidHandler);
        $bus->dispatch($command);
    }
}
