<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. Jansen',
                'email' => 'dr.jansen@example.com',
                'specialization' => 'Huisarts',
                'license_number' => 'D123456',
                'department' => 'Huisartsenpraktijk',
                'phone' => '020-1234567',
                'bio' => 'Huisarts met 15 jaar ervaring, gespecialiseerd in preventieve zorg.'
            ],
            [
                'name' => 'Dr. van Veen',
                'email' => 'dr.vanveen@example.com',
                'specialization' => 'Kinderarts',
                'license_number' => 'D654321',
                'department' => 'Pediatrie',
                'phone' => '020-2345678',
                'bio' => 'Kinderarts met speciale interesse in vaccinaties.'
            ],
            [
                'name' => 'Dr. de Vries',
                'email' => 'dr.devries@example.com',
                'specialization' => 'Internist',
                'license_number' => 'D789012',
                'department' => 'Interne Geneeskunde',
                'phone' => '020-3456789',
                'bio' => 'Internist gespecialiseerd in infectieziekten.'
            ]
        ];

        foreach ($doctors as $doctorData) {
            $user = User::firstOrCreate(
                ['email' => $doctorData['email']],
                [
                    'name' => $doctorData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );

            $department = Department::where('name', $doctorData['department'])->first();

            Doctor::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization' => $doctorData['specialization'],
                    'license_number' => $doctorData['license_number'],
                    'department_id' => $department->id,
                    'phone' => $doctorData['phone'],
                    'bio' => $doctorData['bio']
                ]
            );
        }
    }
}
