<?php

namespace Tests\Unit\Api\Http\Controllers;

use App\Api\Http\Controllers\Controller;
use App\Infrastructure\Core\CommandBus;
use Tests\TestCase;

class DummyController extends Controller
{
    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }
}

class ControllerTest extends TestCase
{
    public function test_command_bus_is_injected_correctly()
    {
        $commandBusMock = $this->createMock(CommandBus::class);

        $controller = new DummyController($commandBusMock);

        $this->assertSame($commandBusMock, $controller->getCommandBus());
    }
}
