@extends('layouts.healthcare')

@section('title', 'Create New Bill')

@section('header', 'Create New Bill')

@section('content')
<a href="{{ route('bills.index') }}">&larr; Back</a>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">

            <h2 class="text-2xl font-bold mb-6">Create New Bill</h2>

            <form action="{{ route('bills.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                    <select name="patient_id" id="patient_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Select a patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="insurance_id" class="block text-sm font-medium text-gray-700">Insurance</label>
                    <select name="insurance_id" id="insurance_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select insurance</option>
                    </select>
                    @error('insurance_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="procedure" class="block text-sm font-medium text-gray-700">Procedure</label>
                    <select name="procedure" id="procedure" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Select a procedure</option>
                        @foreach($procedures as $key => $label)
                            <option value="{{ $key }}" {{ old('procedure') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('procedure')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create Bill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const patientSelect = document.getElementById('patient_id');
    const insuranceSelect = document.getElementById('insurance_id');

    patientSelect.addEventListener('change', function() {
        const patientId = this.value;
        insuranceSelect.innerHTML = '<option value="">Select insurance</option>';

        if (patientId) {
            console.log('Fetching insurances for patient:', patientId);
            fetch(`/bills/patient/${patientId}/insurances`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(insurances => {
                    console.log('Received insurances:', insurances);
                    if (insurances && insurances.length > 0) {
                        insurances.forEach(insurance => {
                            const option = document.createElement('option');
                            option.value = insurance.id;
                            option.textContent = `${insurance.provider} - ${insurance.policy_number}`;
                            insuranceSelect.appendChild(option);
                        });
                    } else {
                        console.log('No insurances found for patient');
                        const option = document.createElement('option');
                        option.value = "";
                        option.textContent = "No active insurances found";
                        insuranceSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error fetching insurances:', error);
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = "Error loading insurances";
                    insuranceSelect.appendChild(option);
                });
        }
    });
});
</script>
@endpush
@endsection
