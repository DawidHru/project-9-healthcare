<?php

namespace Database\Seeders;

use App\Models\MedicalEquipment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MedicalEquipmentSeeder extends Seeder
{
    public function run()
    {
        $equipment = [
            [
                'name' => 'Ultrasound Machine',
                'type' => 'Diagnostic Imaging',
                'serial_number' => 'US-2023-001',
                'purchase_date' => Carbon::now()->subYears(2),
                'last_maintenance' => Carbon::now()->subMonths(3),
                'next_maintenance' => Carbon::now()->addMonths(3),
                'status' => 'available',
                'location' => 'Radiology Room 1',
            ],
            [
                'name' => 'ECG Machine',
                'type' => 'Cardiac Monitoring',
                'serial_number' => 'ECG-2023-002',
                'purchase_date' => Carbon::now()->subYear(),
                'last_maintenance' => Carbon::now()->subMonths(2),
                'next_maintenance' => Carbon::now()->addMonths(4),
                'status' => 'in_use',
                'location' => 'Cardiology Department',
            ],
            [
                'name' => 'Ventilator',
                'type' => 'Life Support',
                'serial_number' => 'VENT-2022-005',
                'purchase_date' => Carbon::now()->subYears(3),
                'last_maintenance' => Carbon::now()->subMonth(),
                'next_maintenance' => Carbon::now()->addMonths(5),
                'status' => 'available',
                'location' => 'ICU Room 3',
            ],
            [
                'name' => 'Defibrillator',
                'type' => 'Emergency',
                'serial_number' => 'DEFIB-2023-010',
                'purchase_date' => Carbon::now()->subMonths(6),
                'last_maintenance' => Carbon::now()->subWeeks(2),
                'next_maintenance' => Carbon::now()->addMonths(6),
                'status' => 'available',
                'location' => 'Emergency Room',
            ],
            [
                'name' => 'Infusion Pump',
                'type' => 'Medication Delivery',
                'serial_number' => 'INF-2023-015',
                'purchase_date' => Carbon::now()->subMonths(4),
                'last_maintenance' => null,
                'next_maintenance' => Carbon::now()->addMonths(12),
                'status' => 'maintenance',
                'location' => 'Maintenance Room',
            ],
            [
                'name' => 'Patient Monitor',
                'type' => 'Vital Signs',
                'serial_number' => 'MON-2022-008',
                'purchase_date' => Carbon::now()->subYears(4),
                'last_maintenance' => Carbon::now()->subMonths(8),
                'next_maintenance' => Carbon::now()->subMonths(2), // Overdue
                'status' => 'available',
                'location' => 'Ward B',
            ],
            [
                'name' => 'X-ray Machine',
                'type' => 'Diagnostic Imaging',
                'serial_number' => 'XRAY-2021-003',
                'purchase_date' => Carbon::now()->subYears(5),
                'last_maintenance' => Carbon::now()->subMonths(1),
                'next_maintenance' => Carbon::now()->addMonths(11),
                'status' => 'available',
                'location' => 'Radiology Room 2',
            ],
            [
                'name' => 'Anesthesia Machine',
                'type' => 'Surgical',
                'serial_number' => 'ANES-2023-007',
                'purchase_date' => Carbon::now()->subMonths(9),
                'last_maintenance' => Carbon::now()->subMonths(2),
                'next_maintenance' => Carbon::now()->addMonths(4),
                'status' => 'in_use',
                'location' => 'Operating Room 1',
            ]
        ];

        foreach ($equipment as $item) {
            MedicalEquipment::create($item);
        }
    }
}