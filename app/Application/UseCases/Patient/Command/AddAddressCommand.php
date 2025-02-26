<?php

namespace App\Application\UseCases\Patient\Command;

class AddAddressCommand
{
    private array $address;
    private array $gps;
    private string $patientId;

    /**
     * @param array $address
     * @param array $gps
     * @param string $patientId
     */
    public function __construct(array $address, array $gps, string $patientId)
    {
        $this->address = $address;
        $this->gps = $gps;
        $this->patientId = $patientId;
    }

    public function getAddress(): array
    {
        return $this->address;
    }

    public function getGps(): array
    {
        return $this->gps;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }
}
