<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Address;
use App\Domain\ValueObjects\AddressVO;
use App\Domain\ValueObjects\GpsVO;

class AddressFactory
{
    public static function create($data): Address
    {
        $patientId = $data['patient_id'];
        $street = $data['address']['street'];
        $city = $data['address']['city'];
        $postalCode = $data['address']['postal_code'];
        $addressVO = new AddressVO($street, $city, $postalCode);
        $gps = ['latitude' => $data['gps']['latitude'], 'longitude' => $data['gps']['longitude']];
        $gpsVO = new GpsVO($gps);

        return new Address($patientId, $addressVO, $gpsVO, null);
    }
}
