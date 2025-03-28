<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\AppointmentStatus;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        // Corrected query to fetch the 'pending' status
        $pendingStatus = AppointmentStatus::where('name', 'pending')->first();

        if (!$pendingStatus) {
            throw new \Exception('The "pending" status is missing in the AppointmentStatus table. Please seed the AppointmentStatusSeeder first.');
        }

        $appointments = [
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'scheduled_time' => now()->addDays(1),
                'reason' => 'Routine checkup',
                'status_id' => $pendingStatus->id,
                'confirmation_status' => 'pending',
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 2,
                'scheduled_time' => now()->addDays(2),
                'reason' => 'Skin rash consultation',
                'status_id' => $pendingStatus->id,
                'confirmation_status' => 'confirmed',
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 3,
                'scheduled_time' => now()->addDays(3),
                'reason' => 'Child vaccination',
                'status_id' => $pendingStatus->id,
                'confirmation_status' => 'pending',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}
