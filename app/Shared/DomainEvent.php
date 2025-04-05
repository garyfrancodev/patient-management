<?php

namespace App\Shared;

use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class DomainEvent
{
    protected string $id;

    protected Carbon $occurredOn;

    public function __construct()
    {
        $this->id = Str::uuid()->toString();
        $this->occurredOn = Carbon::now();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function occurredOn(): Carbon
    {
        return $this->occurredOn;
    }
}
