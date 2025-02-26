<?php

namespace Database\Seeders;

use App\Infrastructure\Persistence\Models\PatientModel;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PatientModel::create([
            'id' => '884aa4cb-287c-455e-9f2e-3f6e0b37e190',
            'user_id' => '884aa4cb-287c-455e-9f2e-3f6e0b37e192',
            'name' => 'John Doe',
            'dob' => '1990-01-15',
            'gender' => 'male',
            'phone' => '+123456789',
        ]);
    }
}
