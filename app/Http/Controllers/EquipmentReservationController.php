<?php

namespace App\Http\Controllers;

use App\Models\EquipmentReservation;
use App\Models\MedicalEquipment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EquipmentReservationController extends Controller
{
    public function index()
    {
        $reservations = EquipmentReservation::with(['equipment', 'staff.user'])
            ->orderBy('start_time', 'desc')
            ->paginate(10);
            
        return view('medical-equipment.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $equipment = MedicalEquipment::where('status', 'available')
            ->orderBy('name')
            ->get();
            
        return view('medical-equipment.reservations.create', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:medical_equipment,id',
            'staff_id' => 'required',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
            'purpose' => 'required|string|max:255'
        ]);

        // Check for overlapping reservations
        $overlapping = EquipmentReservation::where('equipment_id', $validated['equipment_id'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function($query) use ($validated) {
                        $query->where('start_time', '<', $validated['start_time'])
                            ->where('end_time', '>', $validated['end_time']);
                    });
            })
            ->whereIn('status', ['approved', 'pending'])
            ->exists();

        if ($overlapping) {
            return back()->withInput()
                ->with('error', 'The equipment is already reserved for the selected time period.');
        }

        EquipmentReservation::create($validated);

        return redirect()->route('medical-equipment.reservations.index')
            ->with('success', 'Reservation request submitted successfully.');
    }

    public function approve(EquipmentReservation $reservation)
    {
        $reservation->update(['status' => 'approved']);
        
        // Update equipment status
        $reservation->equipment()->update(['status' => 'in_use']);
        
        return back()->with('success', 'Reservation approved successfully.');
    }

    public function reject(EquipmentReservation $reservation)
    {
        $reservation->update(['status' => 'rejected']);
        return back()->with('success', 'Reservation rejected.');
    }

    public function show(EquipmentReservation $reservation)
    {
        return view('medical-equipment.reservations.show', compact('reservation'));
    }

    public function destroy(EquipmentReservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('medical-equipment.reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }
}