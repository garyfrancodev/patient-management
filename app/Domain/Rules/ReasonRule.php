<?php

namespace App\Domain\Rules;

use App\Shared\BusinessRule;

class ReasonRule implements BusinessRule
{
    private string $value;

    private const VALID_REASONS = ['nutritional_advice', 'catering'];

    protected string $message = 'Reason invalid';

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function isValid(): bool
    {
        return in_array($this->value, self::VALID_REASONS);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
