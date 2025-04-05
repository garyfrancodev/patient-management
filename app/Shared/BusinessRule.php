<?php

namespace App\Shared;

interface BusinessRule
{
    public function isValid(): bool;

    public function getMessage(): string;
}
