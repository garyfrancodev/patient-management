<?php

namespace App\Domain\ValueObjects;

class GenderVO
{
    private const ALLOWED = ['male', 'female', 'other'];

    private string $value;

    public function __construct(string $value)
    {
        if (! in_array($value, self::ALLOWED)) {
            throw new InvalidArgumentException("Invalid gender value: {$value}");
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
