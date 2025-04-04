<?php

namespace Database\Seeders;

use App\Models\Insurance;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class InsuranceSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all patients
        $patients = Patient::all();

        // Common insurance providers
        $providers = [
            'Blue Cross Blue Shield',
            'UnitedHealthcare',
            'Aetna',
            'Cigna',
            'Humana',
            'Kaiser Permanente',
            'Medicare',
            'Medicaid'
        ];

        // Create 20 insurance records
        for ($i = 0; $i < 20; $i++) {
            $startDate = $faker->dateTimeBetween('-1 year', 'now');
            $endDate = $faker->dateTimeBetween('now', '+2 years');

            Insurance::create([
                'patient_id' => $patients->random()->id,
                'provider' => $faker->randomElement($providers),
                'policy_number' => $faker->bothify('POL-####-????-####'),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'coverage_details' => [
                    'deductible' => $faker->numberBetween(500, 5000),
                    'copay' => $faker->numberBetween(10, 50),
                    'coinsurance' => $faker->numberBetween(10, 30),
                    'out_of_pocket_max' => $faker->numberBetween(5000, 10000),
                    'prescription_coverage' => $faker->boolean(80), // 80% chance of prescription coverage
                    'vision_coverage' => $faker->boolean(70),
                    'dental_coverage' => $faker->boolean(70),
                ]
            ]);
        }
    }
}
