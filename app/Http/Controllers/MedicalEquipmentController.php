<?php

namespace App\Http\Controllers;

use App\Models\MedicalEquipment;
use App\Models\EquipmentReservation;
use Illuminate\Http\Request;

class MedicalEquipmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Filter de medische apparatuur op basis van de zoekterm
        $medicalEquipments = MedicalEquipment::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('type', 'like', "%{$search}%")
                      ->orWhere('serial_number', 'like', "%{$search}%");
            })
            ->orderByRaw("CASE WHEN status = 'retired' THEN 1 ELSE 0 END") // Prioriteer 'retired' naar beneden
            ->orderBy('name') // Sorteer de rest alfabetisch op naam
            ->paginate(10);

        return view('medical-equipment.index', compact('medicalEquipments'));
    }

    public function create()
    {
        return view('medical-equipment.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:medical_equipment',
            'purchase_date' => 'required|date',
            'last_maintenance' => 'nullable|date',
            'next_maintenance' => 'nullable|date|after_or_equal:last_maintenance',
            'status' => 'required|in:available,in_use,maintenance,out_of_service',
            'location' => 'required|string|max:255',
            'usage_instructions' => 'nullable|string|max:1000'
        ]);

        MedicalEquipment::create($validated);

        return redirect()->route('medical-equipment.index')
            ->with('success', 'Medical equipment added successfully.');
    }

    public function show(MedicalEquipment $equipment)
    {
        $reservations = $equipment->reservations()
            ->with('staff')
            ->orderBy('start_time', 'desc')
            ->paginate(5);
            
        return view('medical-equipment.show', compact('equipment', 'reservations'));
    }

    public function edit(MedicalEquipment $equipment)
    {
        return view('medical-equipment.edit', compact('equipment'));
    }

    public function update(Request $request, MedicalEquipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:medical_equipment,serial_number,'.$equipment->id,
            'purchase_date' => 'required|date',
            'last_maintenance' => 'nullable|date',
            'next_maintenance' => 'nullable|date|after_or_equal:last_maintenance',
            'status' => 'required|in:available,in_use,maintenance,retired',
            'location' => 'required|string|max:255',
            'usage_instructions' => 'nullable|string|max:1000'
        ]);

        $equipment->update($validated);

        return redirect()->route('medical-equipment.show', $equipment)
            ->with('success', 'Equipment details updated successfully.');
    }

    public function logMaintenance(Request $request, MedicalEquipment $equipment)
    {
        $validated = $request->validate([
            'maintenance_date' => 'required|date',
            'next_maintenance' => 'required|date|after:maintenance_date',
        ]);

        $equipment->update([
            'last_maintenance' => $validated['maintenance_date'],
            'next_maintenance' => $validated['next_maintenance']
        ]);

        // Hier zou je ook een maintenance log kunnen bijhouden in een aparte tabel

        return back()->with('success', 'Maintenance logged successfully.');
    }

    public function maintenanceReport()
    {
        $dueForMaintenance = MedicalEquipment::where('next_maintenance', '<=', now()->addDays(14))
            ->orderBy('next_maintenance')
            ->get();
            
        return view('medical-equipment.reports.maintenance', compact('dueForMaintenance'));
    }

    public function usageReport()
    {
        $mostUsed = EquipmentReservation::selectRaw('equipment_id, count(*) as reservation_count')
            ->with('equipment')
            ->groupBy('equipment_id')
            ->orderByDesc('reservation_count')
            ->limit(10)
            ->get();
            
        return view('medical-equipment.reports.usage', compact('mostUsed'));
    }
}
