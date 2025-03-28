<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Models\Vaccination;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'name' => 'Jan de Vries',
                'email' => 'jan@example.com',
                'date_of_birth' => '1985-06-15',
                'gender' => 'male',
                'address' => 'Dorpsstraat 12, 1234 AB Amsterdam',
                'phone' => '0612345678',
                'emergency_contact' => '0634567890 (Maria de Vries)',
                'blood_type' => 'A+',
                'vaccinations' => [
                    [
                        'vaccine_name' => 'COVID-19 Pfizer',
                        'administration_date' => '2021-03-15',
                        'lot_number' => 'PF12345',
                        'next_dose_date' => '2021-06-15',
                        'doctor_email' => 'dr.jansen@example.com'
                    ],
                    [
                        'vaccine_name' => 'Griepvaccin',
                        'administration_date' => '2022-10-10',
                        'lot_number' => 'FLU2022',
                        'next_dose_date' => '2023-10-01',
                        'doctor_email' => 'dr.jansen@example.com'
                    ]
                ]
            ],
            [
                'name' => 'Maria Sanchez',
                'email' => 'maria@example.com',
                'date_of_birth' => '1992-11-22',
                'gender' => 'female',
                'address' => 'Kerklaan 45, 5678 CD Rotterdam',
                'phone' => '0687654321',
                'emergency_contact' => '0645678901 (Carlos Sanchez)',
                'blood_type' => 'B-',
                'vaccinations' => [
                    [
                        'vaccine_name' => 'COVID-19 Moderna',
                        'administration_date' => '2021-04-20',
                        'lot_number' => 'MOD456',
                        'next_dose_date' => '2021-07-20',
                        'doctor_email' => 'dr.vanveen@example.com'
                    ],
                    [
                        'vaccine_name' => 'Tetanus',
                        'administration_date' => '2020-05-12',
                        'lot_number' => 'TET2020',
                        'next_dose_date' => '2025-05-12',
                        'doctor_email' => 'dr.devries@example.com'
                    ]
                ]
            ],
            [
                'name' => 'Sophie van Dam',
                'email' => 'sophie@example.com',
                'date_of_birth' => '2018-05-30',
                'gender' => 'female',
                'address' => 'Lindelaan 3, 3456 GH Den Haag',
                'phone' => '0611223344 (ouders)',
                'emergency_contact' => '0622334455 (Peter van Dam - vader)',
                'blood_type' => 'AB+',
                'vaccinations' => [
                    [
                        'vaccine_name' => 'BMR',
                        'administration_date' => '2019-06-15',
                        'lot_number' => 'MMR2019',
                        'next_dose_date' => null,
                        'doctor_email' => 'dr.vanveen@example.com'
                    ],
                    [
                        'vaccine_name' => 'DKTP',
                        'administration_date' => '2019-07-10',
                        'lot_number' => 'DTAP2019',
                        'next_dose_date' => null,
                        'doctor_email' => 'dr.vanveen@example.com'
                    ]
                ]
            ]
        ];

        foreach ($patients as $patientData) {
            $user = User::firstOrCreate(
                ['email' => $patientData['email']],
                [
                    'name' => $patientData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );

            $patient = Patient::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'date_of_birth' => $patientData['date_of_birth'],
                    'gender' => $patientData['gender'],
                    'address' => $patientData['address'],
                    'phone' => $patientData['phone'],
                    'emergency_contact' => $patientData['emergency_contact'],
                    'blood_type' => $patientData['blood_type']
                ]
            );
    }
}
}
