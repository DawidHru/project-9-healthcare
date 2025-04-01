<?php

namespace Database\Factories;

use App\Models\LabResult;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\LabTechnician;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabResultFactory extends Factory
{
    protected $model = LabResult::class;

    public function definition()
    {
        return [
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'lab_technician_id' => LabTechnician::factory(),
            'test_name' => $this->faker->randomElement(['Blood Test', 'Urine Test', 'X-Ray', 'MRI', 'CT Scan']),
            'test_category' => $this->faker->randomElement(['Hematology', 'Radiology', 'Microbiology', 'Chemistry']),
            'result_value' => $this->faker->sentence(),
            'reference_range' => $this->faker->sentence(),
            'is_abnormal' => $this->faker->boolean(),
            'doctor_notes' => $this->faker->optional()->paragraph(),
            'interpretation' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'reviewed']),
            'test_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
