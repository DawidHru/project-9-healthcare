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
                'usage_instructions' => 'Refer to the user manual for operation.',
            ],
            [
                'name' => 'ECG Machine',
                'type' => 'Cardiac Monitoring',
                'serial_number' => 'ECG-2023-002',
                'purchase_date' => Carbon::now()->subYear(),
                'last_maintenance' => Carbon::now()->subMonths(2),
                'next_maintenance' => Carbon::now()->addMonths(4),
                'status' => 'available',
                'location' => 'Cardiology Department',
                'usage_instructions' => 'Ensure electrodes are properly placed on the patient.',
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
                'usage_instructions' => 'Adjust settings according to patient needs.',
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
                'usage_instructions' => 'Use only in case of cardiac arrest.',
            ],
            [
                'name' => 'Infusion Pump',
                'type' => 'Medication Delivery',
                'serial_number' => 'INF-2023-015',
                'purchase_date' => Carbon::now()->subMonths(4),
                'last_maintenance' => null,
                'next_maintenance' => Carbon::now()->addMonths(12),
                'status' => 'available',
                'location' => 'Maintenance Room',
                'usage_instructions' => 'Ensure proper calibration before use.',
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
                'usage_instructions' => 'Monitor vital signs continuously.',
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
                'usage_instructions' => 'Follow safety protocols during operation.',
            ],
            [
                'name' => 'Anesthesia Machine',
                'type' => 'Surgical',
                'serial_number' => 'ANES-2023-007',
                'purchase_date' => Carbon::now()->subMonths(9),
                'last_maintenance' => Carbon::now()->subMonths(2),
                'next_maintenance' => Carbon::now()->addMonths(4),
                'status' => 'available',
                'location' => 'Operating Room 1',
                'usage_instructions' => 'Ensure proper settings before surgery.',
            ]
        ];

        foreach ($equipment as $item) {
            MedicalEquipment::create($item);
        }
    }
}