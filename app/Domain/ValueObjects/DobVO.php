<?php

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\BirthDateException;
use App\Domain\Rules\MinimumAgeRule;
use App\Shared\ValueObject;
use Carbon\Carbon;

class DobVO extends ValueObject
{
    private Carbon $value;

    public function __construct(Carbon $value)
    {
        $this->checkRule(new BirthDateException(new MinimumAgeRule($value)));

        $this->value = $value;
    }

    public function getValue(): Carbon
    {
        return $this->value;
    }
}
