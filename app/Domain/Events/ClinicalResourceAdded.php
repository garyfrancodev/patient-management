<?php

namespace App\Domain\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ClinicalResourceAdded
{
    use Dispatchable;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        error_log('Evento ClinicalResourceAdded disparado');
    }
}
