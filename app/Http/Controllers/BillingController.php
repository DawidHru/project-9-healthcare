<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $query = Bill::with(['patient', 'insurance', 'paymentTransactions']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by patient
        if ($request->has('patient_id') && $request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filter by due date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('due_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('due_date', '<=', $request->end_date);
        }

        // Filter by amount range
        if ($request->has('min_amount') && $request->min_amount) {
            $query->where('amount', '>=', $request->min_amount);
        }
        if ($request->has('max_amount') && $request->max_amount) {
            $query->where('amount', '<=', $request->max_amount);
        }

        // Filter by remaining balance
        if ($request->has('min_balance') && $request->min_balance) {
            $query->where('remaining_balance', '>=', $request->min_balance);
        }
        if ($request->has('max_balance') && $request->max_balance) {
            $query->where('remaining_balance', '<=', $request->max_balance);
        }

        // Sort by
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        // Validate sort field to prevent SQL injection
        $allowedSortFields = ['created_at', 'amount', 'remaining_balance', 'due_date', 'status'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $bills = $query->paginate(10)->withQueryString();
        $patients = \App\Models\Patient::all();
        $statuses = ['pending', 'paid', 'overdue', 'cancelled'];

        return view('billing.index', compact('bills', 'patients', 'statuses'));
    }

    public function show(Bill $bill)
    {
        $bill->load(['patient', 'insurance', 'paymentTransactions']);
        return view('billing.show', compact('bill'));
    }

    public function create()
    {
        $patients = \App\Models\Patient::all();
        $insurances = \App\Models\Insurance::all();

        // Get all possible procedures from insurance coverage details
        $procedures = [
            'primary_care' => 'Primary Care Visit',
            'specialist_visit' => 'Specialist Visit',
            'emergency_room' => 'Emergency Room Visit',
            'urgent_care' => 'Urgent Care Visit',
            'laboratory_tests' => 'Laboratory Tests',
            'imaging' => 'Imaging Services',
            'surgery' => 'Surgery',
            'prescription_medications' => 'Prescription Medications',
            'physical_therapy' => 'Physical Therapy',
            'mental_health' => 'Mental Health Services',
            'dental_care' => 'Dental Care',
            'vision_care' => 'Vision Care'
        ];

        return view('billing.create', compact('patients', 'insurances', 'procedures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'insurance_id' => 'nullable|exists:insurances,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today',
            'status' => 'required|in:pending,paid,overdue,cancelled',
            'description' => 'nullable|string|max:1000',
            'procedure' => 'required|string'
        ]);

        // Set initial remaining balance equal to amount
        $validated['remaining_balance'] = $validated['amount'];
        $validated['appointment_id'] = null; // Explicitly set appointment_id to null

        $bill = Bill::create($validated);

        return redirect()->route('bills.show', $bill)
            ->with('success', 'Bill created successfully.');
    }

    public function processPayment(Request $request, Bill $bill)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $bill->remaining_balance,
            'payment_method' => 'required|string'
        ]);

        $payment = PaymentTransaction::create([
            'bill_id' => $bill->id,
            'amount' => $validated['amount'],
            'payment_date' => now(),
            'payment_method' => $validated['payment_method'],
            'transaction_id' => 'TRX-' . Str::random(10)
        ]);

        // Calculate new remaining balance after payment
        $newRemainingBalance = $bill->remaining_balance - $validated['amount'];

        // Update bill status based on remaining balance and due date
        if ($newRemainingBalance <= 0) {
            $bill->update([
                'status' => 'paid',
                'remaining_balance' => 0
            ]);
        } elseif ($bill->due_date->isPast()) {
            $bill->update([
                'status' => 'overdue',
                'remaining_balance' => $newRemainingBalance
            ]);
        } else {
            $bill->update([
                'status' => 'pending',
                'remaining_balance' => $newRemainingBalance
            ]);
        }

        return redirect()->route('bills.show', $bill)
            ->with('success', 'Payment processed successfully.');
    }

    public function processInsurancePayment(Bill $bill)
    {
        // Check if bill has insurance and if the procedure is covered
        if (!$bill->insurance) {
            return redirect()->route('bills.show', $bill)
                ->with('error', 'No insurance information available for this bill.');
        }

        $coverageDetails = $bill->insurance->coverage_details;
        if (!isset($coverageDetails[$bill->procedure]) || !$coverageDetails[$bill->procedure]) {
            return redirect()->route('bills.show', $bill)
                ->with('error', 'This procedure is not covered by the insurance.');
        }

        // Create payment transaction for the full amount
        PaymentTransaction::create([
            'bill_id' => $bill->id,
            'amount' => $bill->remaining_balance,
            'payment_date' => now(),
            'payment_method' => 'insurance',
            'transaction_id' => 'INS-' . Str::random(10)
        ]);

        // Update bill status to paid
        $bill->update([
            'status' => 'paid',
            'remaining_balance' => 0
        ]);

        return redirect()->route('bills.show', $bill)
            ->with('success', 'Insurance payment processed successfully.');
    }

    public function generateReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        $bills = Bill::with(['patient', 'insurance', 'paymentTransactions'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalBilled = $bills->sum('amount');
        $totalPaid = $bills->sum(function ($bill) {
            return $bill->paymentTransactions->sum('amount');
        });
        $totalOutstanding = $totalBilled - $totalPaid;

        return view('billing.report', compact('bills', 'totalBilled', 'totalPaid', 'totalOutstanding', 'startDate', 'endDate'));
    }

    public function getPatientInsurances(Patient $patient)
    {
        Log::info('Fetching insurances for patient: ' . $patient->id);

        $insurance = $patient->insurance()
            ->where('start_date', '<=', now())
            ->where('end_date', '>', now())
            ->first();

        $insurances = $insurance ? [$insurance] : [];

        Log::info('Found insurances:', $insurances);

        return response()->json($insurances);
    }
}
