<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // View all appointments (for simplicity, show all appointments)
    public function index(Request $request)
    {
        $patients = Patient::all(); // Fetch all patients for the dropdown
        $query = Appointment::query();

        if ($request->has('patient_id') && $request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        $appointments = $query->get(); // Fetch filtered appointments
        return view('appointments.index', compact('appointments', 'patients'));
    }

    // Show the form to create a new appointment
    public function create()
    {
        $doctors = Doctor::all(); // Fetch all doctors
        return view('appointments.create', compact('doctors'));
    }

    // Store a new appointment
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'scheduled_time' => 'required|date|after:now',
            'reason' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $patient = $user->patient; // Get the associated patient record

        if (!$patient) {
            return back()->with('error', 'No patient record found for this user.');
        }

        Appointment::create([
            'patient_id' => $patient->id, // Use the patient's ID instead of user's ID
            'doctor_id' => $request->doctor_id,
            'scheduled_time' => Carbon::parse($request->scheduled_time)->format('Y-m-d H:i:s'),
            'reason' => $request->reason,
            'status_id' => 1,
            'confirmation_status' => 'pending',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully!');
    }

    // Manage appointments (calendar view)
    public function manage(Request $request)
    {
        $doctors = Doctor::all(); // Fetch all doctors for the dropdown
        return view('appointments.calendar', compact('doctors'));
    }

    // Get calendar events for FullCalendar
    public function calendarEvents(Request $request)
    {
        $query = Appointment::query();

        if ($request->has('doctor_id') && $request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $appointments = $query->with(['patient.user', 'doctor.user'])->get();

        $events = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->patient->user->name,
                'start' => Carbon::parse($appointment->scheduled_time)->format('Y-m-d H:i:s'),
                'backgroundColor' => $this->getAppointmentColor($appointment->confirmation_status),
                'borderColor' => $this->getAppointmentColor($appointment->confirmation_status),
            ];
        });

        return response()->json($events);
    }

    // Get appointments for a specific date
    public function getAppointmentsByDate(Request $request, $date)
    {
        $query = Appointment::query()
            ->whereDate('scheduled_time', Carbon::parse($date)->format('Y-m-d'))
            ->with(['patient.user', 'doctor.user']);

        if ($request->has('doctor_id') && $request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $appointments = $query->get();
        return response()->json($appointments);
    }

    // Helper method to get appointment color based on status
    private function getAppointmentColor($status)
    {
        return match ($status) {
            'pending' => '#FFA500', // Orange
            'confirmed' => '#4CAF50', // Green
            'cancelled' => '#f44336', // Red
            default => '#2196F3', // Blue
        };
    }

    // Approve an appointment
    public function approve(Appointment $appointment)
    {
        $appointment->confirm();
        return response()->json(['success' => true]);
    }

    // Reschedule an appointment
    public function reschedule(Request $request, Appointment $appointment)
    {
        $request->validate(['rescheduled_time' => 'required|date|after:now']);
        $appointment->reschedule($request->rescheduled_time);
        return response()->json(['success' => true]);
    }

    // Cancel an appointment
    public function cancel(Appointment $appointment)
    {
        $appointment->cancel();
        return response()->json(['success' => true]);
    }
}
