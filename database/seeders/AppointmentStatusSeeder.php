<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentStatus;

class AppointmentStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'pending', 'description' => 'Appointment is awaiting confirmation.'],
            ['name' => 'confirmed', 'description' => 'Appointment has been confirmed.'],
            ['name' => 'rescheduled', 'description' => 'Appointment has been rescheduled.'],
            ['name' => 'cancelled', 'description' => 'Appointment has been cancelled.'],
        ];

        foreach ($statuses as $status) {
            AppointmentStatus::create($status);
        }
    }
}
