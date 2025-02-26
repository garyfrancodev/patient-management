<?php

namespace App\Application\UseCases\Patient\Command;

use Carbon\Carbon;

class CreatePatientCommand
{
    private Carbon $dob;
    private string $dni;
    private string $email;
    private array $fullName;
    private string $gender;
    private string $phone;
    private string $userId;

    /**
     * @param Carbon $dob
     * @param string $dni
     * @param string $email
     * @param array $fullName
     * @param string $gender
     * @param string $phone
     * @param string $userId
     */
    public function __construct(Carbon $dob, string $dni, string $email, array $fullName, string $gender, string $phone, string $userId)
    {
        $this->dob = $dob;
        $this->dni = $dni;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->gender = $gender;
        $this->phone = $phone;
        $this->userId = $userId;
    }

    public function getDob(): Carbon
    {
        return $this->dob;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): array
    {
        return $this->fullName;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }


}
