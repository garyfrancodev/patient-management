<?php

namespace App\Domain\ValueObjects;

class AddressVO
{
    private string $street;

    private string $city;

    private string $postalCode;

    public function __construct(string $street, string $city, string $postalCode)
    {
        if (empty($street) || empty($city) || empty($postalCode)) {
            throw new \InvalidArgumentException('Street, city, and postal code cannot be empty.');
        }

        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
    }

    public function getValue(): string
    {
        return "{$this->street}, {$this->city}, {$this->postalCode}";
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }
}
