<?php

namespace App\Domain\ValueObjects;

class DniVO
{
    private string $dni;

    public function __construct(string $dni)
    {

        if (empty($dni)) {
            throw new \InvalidArgumentException('Identification number cannot be empty.');
        }

        $this->dni = $dni;
    }

    public function __toString(): string
    {
        return $this->dni;
    }

    public function getDni(): string
    {
        return $this->dni;
    }
}
