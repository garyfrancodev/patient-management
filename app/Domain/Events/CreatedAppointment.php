<?php

namespace App\Domain\Events;

use Illuminate\Foundation\Events\Dispatchable;

class CreatedAppointment
{
    use Dispatchable;

    /**
     * Create a new event instance.
     */
    public function __construct() {}
}
