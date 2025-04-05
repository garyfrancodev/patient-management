<?php

namespace App\Domain\ValueObjects;

use App\Shared\ValueObject;

class GpsVO extends ValueObject
{
    private array $coordinates;

    public function __construct(array $coordinates)
    {
        if (! isset($coordinates['latitude']) || ! isset($coordinates['longitude'])) {
            throw new InvalidArgumentException('Las coordenadas GPS deben tener latitud y longitud.');
        }

        $this->coordinates = $coordinates;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function toJson(): string
    {
        return json_encode($this->coordinates);
    }

    public function fromJson(string $json): self
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Error al decodificar el JSON');
        }

        return new self($data);
    }
}
