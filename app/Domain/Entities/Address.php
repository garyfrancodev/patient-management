<?php

namespace App\Domain\Entities;

use App\Domain\Events\AddressCreated;
use App\Domain\ValueObjects\AddressVO;
use App\Domain\ValueObjects\GpsVO;
use App\Shared\Entity;

class Address extends Entity
{
    private string $patientId;

    private AddressVO $addressVO;

    private GpsVO $gpsVO;

    public function __construct(string $patientId, AddressVO $addressVO, GpsVO $gpsVO, ?string $id)
    {
        parent::__construct($id);
        $this->patientId = $patientId;
        $this->addressVO = $addressVO;
        $this->gpsVO = $gpsVO;

        $this->domainEvents[] = new AddressCreated($patientId);
    }

    public function updateAddress($newAddressVO)
    {
        $this->addressVO = $newAddressVO;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getAddressVO(): AddressVO
    {
        return $this->addressVO;
    }

    public function getGpsVO(): GpsVO
    {
        return $this->gpsVO;
    }
}
