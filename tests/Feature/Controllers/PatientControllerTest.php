<?php

namespace Tests\Feature\Controllers;

use App\Application\UseCases\Patient\Command\CreatePatientCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_store_creates_patient_and_returns_201()
    {
        Bus::fake();

        $payload = [
            'user_id' => 'user_123',
            'full_name' => ['first_name' => 'John', 'last_name' => 'Doe'],
            'email' => 'john.doe@example.com',
            'dni' => 'A123456789',
            'phone' => '123456789',
            'dob' => '2000-05-15',
            'gender' => 'male',
        ];

        $response = $this->postJson('/api/v1/patient', $payload);

        $response->assertStatus(201);
        Bus::assertDispatched(CreatePatientCommand::class);
    }

    public function test_store_returns_400_for_invalid_data()
    {
        $payload = [
            'user_id' => '',
            'email' => 'not-an-email',
            'dni' => '',
            'phone' => 'not-a-phone',
            'dob' => 'invalid-date',
            'gender' => 'not-valid',
        ];

        $response = $this->postJson('/api/v1/patient', $payload);

        $response->assertStatus(400);
    }
}
