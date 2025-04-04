<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Patient;
use App\Models\Insurance;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BillSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Get all patients, insurances, and appointments
        $patients = Patient::all();
        $insurances = Insurance::all();
        $appointments = Appointment::all();

        // Common medical procedures and their typical costs
        $procedures = [
            'General Checkup' => [100, 200],
            'Specialist Consultation' => [150, 300],
            'Blood Test' => [50, 150],
            'X-Ray' => [100, 300],
            'MRI' => [500, 2000],
            'Surgery' => [1000, 5000],
            'Emergency Room Visit' => [500, 2000],
            'Prescription Medication' => [20, 200],
            'Physical Therapy' => [100, 300],
            'Dental Cleaning' => [80, 200]
        ];

        // Create 50 bills
        for ($i = 0; $i < 50; $i++) {
            $procedure = $faker->randomElement(array_keys($procedures));
            $costRange = $procedures[$procedure];
            $amount = $faker->numberBetween($costRange[0], $costRange[1]);

            // Randomly decide if bill has insurance
            $hasInsurance = $faker->boolean(70); // 70% chance of having insurance
            $insuranceId = $hasInsurance ? $insurances->random()->id : null;

            // Generate due date (between 1 and 90 days from now)
            $dueDate = $faker->dateTimeBetween('now', '+90 days');

            // Determine status based on due date and random factors
            $status = 'pending';
            if ($faker->boolean(30)) { // 30% chance of being paid
                $status = 'paid';
            } elseif ($dueDate < now() && $faker->boolean(40)) { // 40% chance of being overdue if past due date
                $status = 'overdue';
            }

            Bill::create([
                'patient_id' => $patients->random()->id,
                'appointment_id' => $appointments->random()->id,
                'amount' => $amount,
                'status' => $status,
                'due_date' => $dueDate,
                'insurance_id' => $insuranceId,
                'description' => $procedure
            ]);
        }
    }
}
