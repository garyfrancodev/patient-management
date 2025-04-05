<?php

namespace App\Domain\Rules;

use App\Shared\BusinessRule;

class StringNotNullOrEmptyRule implements BusinessRule
{
    private ?string $value;

    protected string $message = 'The value is required';

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    public function isValid(): bool
    {
        return ! empty($this->value);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
