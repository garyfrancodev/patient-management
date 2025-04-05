<?php

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\ReasonException;
use App\Domain\Exceptions\StringNotNullOrEmptyException;
use App\Domain\Rules\ReasonRule;
use App\Domain\Rules\StringNotNullOrEmptyRule;
use App\Shared\BusinessRuleValidationException;
use App\Shared\ValueObject;

class ReasonVO extends ValueObject
{
    private ?string $value;

    /**
     * @throws BusinessRuleValidationException
     */
    public function __construct(?string $value)
    {
        $this->checkRule(new StringNotNullOrEmptyException(new StringNotNullOrEmptyRule($value)));
        $this->checkRule(new ReasonException(new ReasonRule($value)));

        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
