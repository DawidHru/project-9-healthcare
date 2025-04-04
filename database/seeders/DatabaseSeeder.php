<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\MedicalEquipment;
use App\Models\Vaccination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */  public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
       
         // Aanvullende testpatiënten zonder vaccinaties

        // Aanvullende testpatiënten zonder vaccinaties
        for ($i = 1; $i <= 10; $i++) {
            $user = User::firstOrCreate(
                ['email' => 'patient' . $i . '@example.com'],
                [
                    'name' => 'Testpatiënt ' . $i,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]
            );

            Patient::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'date_of_birth' => Carbon::now()->subYears(rand(5, 70))->subMonths(rand(0, 11))->subDays(rand(0, 30)),
                    'gender' => ['male', 'female', 'other'][rand(0, 2)],
                    'address' => 'Voorbeeldstraat ' . $i . ', 123' . $i . ' AB Teststad',
                    'phone' => '06' . rand(10000000, 99999999),
                    'emergency_contact' => '06' . rand(10000000, 99999999) . ' (Noodcontact)',
                    'blood_type' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'][rand(0, 7)]
                ]
            );
        }

        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            StaffSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            VaccinationSeeder::class,
            AppointmentStatusSeeder::class,
            AppointmentSeeder::class,
            ScheduleSeeder::class,
            InventorySeeder::class,
            MedicalEquipmentSeeder::class,
            InventorySeeder::class,
            ScheduleSeeder::class,

            LabTechnicianSeeder::class,
            InsuranceSeeder::class,
            BillSeeder::class,
        ]);
    }
}
