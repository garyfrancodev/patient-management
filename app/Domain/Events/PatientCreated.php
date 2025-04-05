<?php

namespace App\Domain\Events;

use App\Shared\DomainEvent;
use Illuminate\Foundation\Events\Dispatchable;

class PatientCreated extends DomainEvent
{
    use Dispatchable;

    private string $email;

    public function __construct(string $email)
    {
        parent::__construct();
        $this->email = $email;
        error_log('added PatientCreatedEvent');
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
