<?php

namespace Tests\Feature;

use App\Models\LabResult;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabResultTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_lab_results_list()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create();
        $labResult = LabResult::factory()->create(['patient_id' => $patient->id]);

        $response = $this->actingAs($user)->get(route('lab-results.index'));

        $response->assertStatus(200);
        $response->assertSee($labResult->test_name);
    }

    public function test_can_create_lab_result()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create();

        $response = $this->actingAs($user)->post(route('lab-results.store'), [
            'patient_id' => $patient->id,
            'test_name' => 'Blood Test',
            'test_category' => 'Hematology',
            'result_value' => 'Normal',
            'reference_range' => 'Normal Range',
            'test_date' => now()->format('Y-m-d'),
            'is_abnormal' => false,
        ]);

        $response->assertRedirect(route('lab-results.index'));
        $this->assertDatabaseHas('lab_results', [
            'test_name' => 'Blood Test',
            'test_category' => 'Hematology',
        ]);
    }

    public function test_can_update_lab_result()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create();
        $labResult = LabResult::factory()->create(['patient_id' => $patient->id]);

        $response = $this->actingAs($user)->put(route('lab-results.update', $labResult), [
            'patient_id' => $patient->id,
            'test_name' => 'Updated Blood Test',
            'test_category' => 'Hematology',
            'result_value' => 'Abnormal',
            'reference_range' => 'Normal Range',
            'test_date' => now()->format('Y-m-d'),
            'is_abnormal' => true,
            'status' => 'completed',
        ]);

        $response->assertRedirect(route('lab-results.index'));
        $this->assertDatabaseHas('lab_results', [
            'id' => $labResult->id,
            'test_name' => 'Updated Blood Test',
            'result_value' => 'Abnormal',
            'is_abnormal' => true,
        ]);
    }

    public function test_can_delete_lab_result()
    {
        $user = User::factory()->create();
        $patient = Patient::factory()->create();
        $labResult = LabResult::factory()->create(['patient_id' => $patient->id]);

        $response = $this->actingAs($user)->delete(route('lab-results.destroy', $labResult));

        $response->assertRedirect(route('lab-results.index'));
        $this->assertDatabaseMissing('lab_results', [
            'id' => $labResult->id,
        ]);
    }
}
