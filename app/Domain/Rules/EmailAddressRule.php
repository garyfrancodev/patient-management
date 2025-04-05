<?php

namespace App\Domain\Rules;

use App\Shared\BusinessRule;

class EmailAddressRule implements BusinessRule
{
    private string $value;

    protected string $message = 'EmailVO format invalid';

    protected static string $EMAIL_PATTERN = '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,6}$/';

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function isValid(): bool
    {
        return preg_match(self::$EMAIL_PATTERN, $this->value);
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
