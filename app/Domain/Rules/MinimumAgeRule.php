<?php

namespace App\Domain\Rules;

use App\Shared\BusinessRule;
use Carbon\Carbon;

class MinimumAgeRule implements BusinessRule
{
    private Carbon $value;

    protected const MINIMUM_AGE = 18;

    protected const MESSAGE = 'Debes ser mayor de edad';

    public function __construct(Carbon $value)
    {
        $this->value = $value;
    }

    public function isValid(): bool
    {
        return $this->value->age >= self::MINIMUM_AGE;
    }

    public function getMessage(): string
    {
        return self::MESSAGE;
    }
}
