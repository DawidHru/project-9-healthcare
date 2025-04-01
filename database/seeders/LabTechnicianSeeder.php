<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\LabTechnician;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LabTechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labTechnicians = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'certification' => 'MLT (ASCP)',
                'department' => 'Laboratorium',
                'employee_id' => 'LT001',
                'phone' => '020-1234568',
                'bio' => 'Ervaren laboratoriumtechnicus gespecialiseerd in hematologie.'
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@example.com',
                'certification' => 'MLS (ASCP)',
                'department' => 'Laboratorium',
                'employee_id' => 'LT002',
                'phone' => '020-2345679',
                'bio' => 'Laboratoriumspecialist met expertise in microbiologie.'
            ],
            [
                'name' => 'Emma de Vries',
                'email' => 'emma.devries@example.com',
                'certification' => 'MLT (ASCP)',
                'department' => 'Laboratorium',
                'employee_id' => 'LT003',
                'phone' => '020-3456780',
                'bio' => 'Laboratoriumtechnicus gespecialiseerd in klinische chemie.'
            ]
        ];

        foreach ($labTechnicians as $technicianData) {
            $user = User::firstOrCreate(
                ['email' => $technicianData['email']],
                [
                    'name' => $technicianData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );

            $department = Department::firstOrCreate(
                ['name' => $technicianData['department']],
                [
                    'location' => 'Begane grond, achter',
                    'work_days' => 'Monday - Friday' // Add a default value for work_days
                ]
            );

            $staff = Staff::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'position' => 'Laboratoriumtechnicus',
                    'department_id' => $department->id,
                    'employee_id' => $technicianData['employee_id'],
                    'phone' => $technicianData['phone'],
                    'bio' => $technicianData['bio']
                ]
            );

            LabTechnician::firstOrCreate(
                ['staff_id' => $staff->id],
                [
                    'certification' => $technicianData['certification']
                ]
            );
        }
    }
}
