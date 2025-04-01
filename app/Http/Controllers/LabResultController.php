<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\LabTechnician;
use Illuminate\Http\Request;

class LabResultController extends Controller
{

    public function index()
    {
        $query = LabResult::with(['patient.user', 'doctor.user', 'labTechnician.staff.user']);

        // Apply filters
        if (request('patient_id')) {
            $query->where('patient_id', request('patient_id'));
        }

        if (request('doctor_id')) {
            $query->where('doctor_id', request('doctor_id'));
        }

        if (request('lab_technician_id')) {
            $query->where('lab_technician_id', request('lab_technician_id'));
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('is_abnormal')) {
            $query->where('is_abnormal', true);
        }

        $labResults = $query->latest()->paginate(10);

        // Get data for filter dropdowns
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $labTechnicians = LabTechnician::with('staff.user')->get();

        return view('lab-results.index', compact('labResults', 'patients', 'doctors', 'labTechnicians'));
    }

    public function create(Request $request)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $labTechnicians = LabTechnician::all();
        return view('lab-results.create', compact('patients', 'doctors', 'labTechnicians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'lab_technician_id' => 'required|exists:lab_technicians,id',
            'test_name' => 'required|string|max:255',
            'test_category' => 'required|string|max:255',
            'result_value' => 'required|string',
            'reference_range' => 'nullable|string',
            'is_abnormal' => 'boolean',
            'test_date' => 'required|date',
            'status' => 'required|in:pending,completed,reviewed',
        ]);

        LabResult::create($validated);
        return redirect()->route('lab-results.index')
            ->with('success', 'Lab result created successfully.');
    }

    public function show(LabResult $labResult)
    {
        // Get previous results for the same test and patient
        $previousResults = LabResult::where('patient_id', $labResult->patient_id)
            ->where('test_name', $labResult->test_name)
            ->where('id', '!=', $labResult->id)
            ->orderBy('test_date', 'desc')
            ->get();

        return view('lab-results.show', compact('labResult', 'previousResults'));
    }

    public function edit(LabResult $labResult)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $labTechnicians = LabTechnician::all();
        return view('lab-results.edit', compact('labResult', 'patients', 'doctors', 'labTechnicians'));
    }

    public function update(Request $request, LabResult $labResult)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'lab_technician_id' => 'required|exists:lab_technicians,id',
            'test_name' => 'required|string|max:255',
            'test_category' => 'required|string|max:255',
            'result_value' => 'required|string',
            'reference_range' => 'nullable|string',
            'is_abnormal' => 'boolean',
            'test_date' => 'required|date',
            'doctor_notes' => 'nullable|string',
            'status' => 'required|in:pending,completed,reviewed',
        ]);

        $labResult->update($validated);

        return redirect()->route('lab-results.index')
            ->with('success', 'Lab result updated successfully.');
    }

    public function destroy(LabResult $labResult)
    {
        $labResult->delete();
        return redirect()->route('lab-results.index')
            ->with('success', 'Lab result deleted successfully.');
    }
}
