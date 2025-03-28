<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use PDF; // For generating PDF certificates

class VaccinationController extends Controller
{
    public function index()
    {
        $vaccinations = Vaccination::with(['patient', 'doctor'])
            ->latest()
            ->paginate(10);
            
        return view('vaccinations.index', compact('vaccinations'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('vaccinations.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'vaccine_name' => 'required|string|max:255',
            'administration_date' => 'required|date',
            'lot_number' => 'required|string|max:255',
            'next_dose_date' => 'nullable|date|after:administration_date',
        ]);

        Vaccination::create($validated);

        return redirect()->route('vaccinations.index')
            ->with('success', 'Vaccination record created successfully.');
    }

    public function show(Vaccination $vaccination)
    {
        return view('vaccinations.show', compact('vaccination'));
    }

    public function edit(Vaccination $vaccination)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('vaccinations.edit', compact('vaccination', 'patients', 'doctors'));
    }

    public function update(Request $request, Vaccination $vaccination)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'vaccine_name' => 'required|string|max:255',
            'administration_date' => 'required|date',
            'lot_number' => 'required|string|max:255',
            'next_dose_date' => 'nullable|date|after:administration_date',
        ]);
        
        $vaccination->update($validated);
        
        return redirect()->route('vaccinations.show', $vaccination)
        ->with('success', 'Vaccination record updated successfully.');
    }

    public function destroy(Vaccination $vaccination)
    {
        $vaccination->delete();

        return redirect()->route('vaccinations.index')
            ->with('success', 'Vaccination record deleted successfully.');
    }

    // Patient-specific methods
    public function patientHistory(Patient $patient, Request $request)
    {
        $vaccinations = Vaccination::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('administration_date', 'desc')
            ->get();

        // Haal het vaccinatie-ID op uit de queryparameters
        $vaccinationId = $request->query('vaccination_id');

        return view('vaccinations.patient.history', compact('vaccinations', 'patient', 'vaccinationId'));
    }

    public function upcomingVaccines(Patient $patient)
    {
        $upcoming = Vaccination::where('patient_id', $patient->id)
            ->whereNotNull('next_dose_date')
            ->where('next_dose_date', '>=', now())
            ->with('doctor')
            ->orderBy('next_dose_date')
            ->get();
            
        $recommended = $this->getRecommendedVaccines($patient);
            
        return view('vaccinations.patient.schedule', compact('upcoming', 'patient', 'recommended'));
    }

    // In je controller
    public function showCertificate(Patient $patient)
    {
        $vaccinations = $patient->vaccinations()->orderBy('administration_date')->get();
        return view('vaccinations.patient.certificate', compact('patient', 'vaccinations'));
    }

    public function reminders()
    {
        $dueVaccines = Vaccination::whereNotNull('next_dose_date')
            ->where('next_dose_date', '<=', now()->addDays(7))
            ->where('next_dose_date', '>=', now())
            ->with(['patient', 'doctor'])
            ->get();
            
        $overdueVaccines = Vaccination::whereNotNull('next_dose_date')
            ->where('next_dose_date', '<', now())
            ->with(['patient', 'doctor'])
            ->get();
            
        return view('vaccinations.reminders', compact('dueVaccines', 'overdueVaccines'));
    }

    protected function getRecommendedVaccines(Patient $patient)
    {
        // This is a simplified example - you would implement actual vaccine recommendations
        // based on age, health status, existing vaccinations, etc.
        $birthTimestamp = strtotime($patient->date_of_birth); // Zet de geboortedatum om naar een timestamp
        $currentTimestamp = time(); // Huidige timestamp
        $age = floor(($currentTimestamp - $birthTimestamp) / (365 * 24 * 60 * 60)); // Bereken het verschil in jaren
        $recommended = [];
        
        if ($age < 2) {
            $recommended[] = ['name' => 'DTaP', 'description' => 'Diphtheria, Tetanus, and Pertussis'];
            $recommended[] = ['name' => 'Hib', 'description' => 'Haemophilus influenzae type b'];
        }
        
        if ($age >= 65) {
            $recommended[] = ['name' => 'Shingles', 'description' => 'Shingles vaccine'];
            $recommended[] = ['name' => 'Pneumococcal', 'description' => 'Pneumonia vaccine'];
        }
        
        return $recommended;
    }
}
