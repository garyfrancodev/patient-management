<?php

namespace App\Domain\Events;

use App\Shared\DomainEvent;
use Illuminate\Foundation\Events\Dispatchable;

class AddressCreated extends DomainEvent
{
    use Dispatchable;

    private string $patientId;

    public function __construct(string $patientId)
    {
        parent::__construct();
        $this->patientId = $patientId;
        error_log('added AddressCreatedEvent');
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }
}
