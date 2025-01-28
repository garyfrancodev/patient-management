<?php

namespace Tests\Unit\Domain;

use App\Domain\Entities\DietaryPreference;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DietaryPreferenceTest extends TestCase
{
    #[Test]
    public function valid_create_domain(): void
    {
        $patientId = Str::uuid()->toString();
        $preference = "Cerdo";
        $domain = new DietaryPreference($patientId, $preference);

        $id = $domain->getId();
        $this->assertTrue($this->_isValidUUID($id), "The ID is not a valid UUID.");
    }

    private function _isValidUUID(string $uuid): bool
    {
        return !(preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid) !== 1);
    }
}
