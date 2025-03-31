<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Vaccination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient; // Zorg ervoor dat het Patient-model is geïmporteerd

class VaccinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Haal een specifieke patiënt op
        $patient = Patient::first(); // Haal de eerste patiënt op uit de database

        if (!$patient) {
            throw new \Exception('Geen patiënt gevonden in de database.');
        }

        // Voorbeeldgegevens voor vaccinaties
        $vaccinationData = [
            [
                'vaccine_name' => 'COVID-19 Vaccine',
                'administration_date' => '2025-03-01',
                'lot_number' => 'ABC123',
                'next_dose_date' => '2025-06-01',
                'doctor_email' => 'doctor1@example.com',
            ],
            [
                'vaccine_name' => 'Influenza Vaccine',
                'administration_date' => '2025-02-15',
                'lot_number' => 'XYZ789',
                'next_dose_date' => null,
                'doctor_email' => 'doctor2@example.com',
            ],
        ];

        foreach ($vaccinationData as $data) {
            $doctor = Doctor::whereHas('user', function ($q) use ($data) {
                $q->where('email', $data['doctor_email']);
            })->first();

            if (!$doctor) {
                continue; // Sla over als de dokter niet wordt gevonden
            }

            Vaccination::firstOrCreate(
                [
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'vaccine_name' => $data['vaccine_name'],
                    'administration_date' => $data['administration_date'],
                ],
                [
                    'lot_number' => $data['lot_number'],
                    'next_dose_date' => $data['next_dose_date'],
                ]
            );
        }
    }
}