@extends('layouts.healthcare')

@section('title', isset($insurance) ? 'Edit Insurance' : 'Add New Insurance')

@section('header')
    {{ isset($insurance) ? 'Edit Insurance' : 'Add New Insurance' }}
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ isset($insurance) ? route('insurance.update', $insurance) : route('insurance.store') }}" method="POST" class="space-y-8">
                @csrf
                @if(isset($insurance))
                    @method('PUT')
                @endif

                <!-- Patient Selection -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="col-span-2">
                        <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
                        <select name="patient_id" id="patient_id" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                            {{ isset($insurance) ? 'disabled' : '' }}>
                            <option value="">Select a patient</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ (isset($insurance) && $insurance->patient_id == $patient->id) || old('patient_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->user->name }} (ID: {{ $patient->id }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Insurance Details -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="provider" class="block text-sm font-medium text-gray-700">Insurance Provider</label>
                        <input type="text" name="provider" id="provider" value="{{ $insurance->provider ?? old('provider') }}"
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required>
                        @error('provider')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="policy_number" class="block text-sm font-medium text-gray-700">Policy Number</label>
                        <input type="text" name="policy_number" id="policy_number" value="{{ $insurance->policy_number ?? old('policy_number') }}"
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required>
                        @error('policy_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Coverage Period -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                            value="{{ isset($insurance) ? $insurance->start_date->format('Y-m-d') : old('start_date') }}"
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required>
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ isset($insurance) ? $insurance->end_date->format('Y-m-d') : old('end_date') }}"
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required>
                        @error('end_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Coverage Details -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Coverage Details</h3>
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @php
                                $services = [
                                    'general_checkup' => 'General Checkup',
                                    'emergency_care' => 'Emergency Care',
                                    'prescription_drugs' => 'Prescription Drugs',
                                    'laboratory_tests' => 'Laboratory Tests',
                                    'imaging_services' => 'Imaging Services',
                                    'specialist_visits' => 'Specialist Visits',
                                    'hospitalization' => 'Hospitalization',
                                    'surgery' => 'Surgery',
                                    'mental_health' => 'Mental Health',
                                    'dental_care' => 'Dental Care',
                                    'vision_care' => 'Vision Care',
                                    'physical_therapy' => 'Physical Therapy'
                                ];
                            @endphp

                            @foreach($services as $key => $label)
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="coverage_details[{{ $key }}]" id="coverage_{{ $key }}"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                            {{ (isset($insurance) && isset($insurance->coverage_details[$key]) && $insurance->coverage_details[$key]) || old("coverage_details.$key") ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="coverage_{{ $key }}" class="font-medium text-gray-700">{{ $label }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('insurance.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ isset($insurance) ? 'Update Insurance' : 'Create Insurance' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Add client-side validation if needed
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // Ensure end date is not before start date
            startDateInput.addEventListener('change', function() {
                endDateInput.min = this.value;
            });

            endDateInput.addEventListener('change', function() {
                if (startDateInput.value && this.value < startDateInput.value) {
                    this.value = startDateInput.value;
                }
            });
        });
    </script>
    @endpush
@endsection
