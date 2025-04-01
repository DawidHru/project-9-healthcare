<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run()
    {
        // Get all regular users (excluding the admin)
        $users = User::where('email', '!=', 'admin@example.com')->get();
        $departments = Department::all();

        $positions = [
            'Nurse', 'Lab Technician', 'Receptionist', 
            'Administrator', 'Inventory Manager'
        ];

        foreach ($users as $index => $user) {
            Staff::create([
                'user_id' => $user->id,
                'position' => $positions[$index % count($positions)],
                'department_id' => $departments->random()->id,
                'employee_id' => 'EMP' . str_pad($index + 1, 4, '0', STR_PAD_LEFT)
            ]);
        }

        // Optionally create some random staff if you have factories
        // Staff::factory(3)->create();
    }
}