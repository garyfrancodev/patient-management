<?php

namespace App\Domain\ValueObjects;

class FullNameVO
{
    private string $firstName;

    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        if (empty($firstName) || empty($lastName)) {
            throw new \InvalidArgumentException('First and last name cannot be empty.');
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}
