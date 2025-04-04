<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InsuranceController extends Controller
{
    public function index()
    {
        $insurances = Insurance::with('patient')
            ->latest()
            ->paginate(10);

        return view('insurance.index', compact('insurances'));
    }

    public function show(Insurance $insurance)
    {
        $insurance->load(['patient', 'bills']);
        return view('insurance.show', compact('insurance'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('insurance.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'provider' => 'required|string|max:255',
            'policy_number' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'coverage_details' => 'nullable|array'
        ]);

        // Format dates to include time component
        $validated['start_date'] = Carbon::parse($validated['start_date'])->startOfDay();
        $validated['end_date'] = Carbon::parse($validated['end_date'])->endOfDay();

        // Process coverage details
        if (isset($validated['coverage_details'])) {
            $coverageDetails = [];
            foreach ($validated['coverage_details'] as $key => $value) {
                $coverageDetails[$key] = $value === '1' || $value === true;
            }
            $validated['coverage_details'] = $coverageDetails;
        }

        $insurance = Insurance::create($validated);

        return redirect()->route('insurance.show', $insurance)
            ->with('success', 'Insurance information added successfully.');
    }

    public function edit(Insurance $insurance)
    {
        $patients = Patient::all();
        return view('insurance.edit', compact('insurance', 'patients'));
    }

    public function update(Request $request, Insurance $insurance)
    {
        $validated = $request->validate([
            'provider' => 'required|string|max:255',
            'policy_number' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'coverage_details' => 'nullable|array'
        ]);

        // Format dates to include time component
        $validated['start_date'] = Carbon::parse($validated['start_date'])->startOfDay();
        $validated['end_date'] = Carbon::parse($validated['end_date'])->endOfDay();

        // Process coverage details
        if (isset($validated['coverage_details'])) {
            $coverageDetails = [];
            foreach ($validated['coverage_details'] as $key => $value) {
                $coverageDetails[$key] = $value === '1' || $value === true;
            }
            $validated['coverage_details'] = $coverageDetails;
        }

        $insurance->update($validated);

        return redirect()->route('insurance.show', $insurance)
            ->with('success', 'Insurance information updated successfully.');
    }

    public function destroy(Insurance $insurance)
    {
        $insurance->delete();

        return redirect()->route('insurance.index')
            ->with('success', 'Insurance information deleted successfully.');
    }

    public function checkCoverage(Request $request, Insurance $insurance)
    {
        $service = $request->input('service');

        if (!$insurance->coverage_details) {
            return response()->json([
                'covered' => false,
                'message' => 'No coverage details available'
            ]);
        }

        $isCovered = isset($insurance->coverage_details[$service]) &&
            $insurance->coverage_details[$service] === true;

        return response()->json([
            'covered' => $isCovered,
            'message' => $isCovered ? 'Service is covered' : 'Service is not covered'
        ]);
    }
}
