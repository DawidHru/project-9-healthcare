<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Huisartsenpraktijk',
                'location' => 'Begane grond, links',
                'work_days'   => 'Monday - Saturday',
            ],
            [
                'name' => 'Pediatrie', 
                'location' => 'Eerste verdieping, rechts',
                'work_days'   => 'Monday - Saturday',
            ],
            [
                'name' => 'Interne Geneeskunde',
                'location' => 'Tweede verdieping',
                'work_days'   => 'Monday - Sunday',
            ],
            [
                'name' => 'Chirurgie',
                'location' => 'Begane grond, rechts',
                'work_days'   => 'Monday - Friday',
            ],
            [
                'name' => 'Gynaecologie',
                'location' => 'Eerste verdieping, links',
                'work_days'   => 'Tuesday - Saturday',
            ],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept['name']], $dept);
        }
    }
}
