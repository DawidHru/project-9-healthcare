@extends('layouts.healthcare')

@section('title', 'Edit Insurance')

@section('header', 'Edit Insurance')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('insurance.update', $insurance) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Insurance Details -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="provider" class="block text-sm font-medium text-gray-700">Insurance Provider</label>
                        <input type="text" name="provider" id="provider" value="{{ old('provider', $insurance->provider) }}"
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required>
                        @error('provider')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="policy_number" class="block text-sm font-medium text-gray-700">Policy Number</label>
                        <input type="text" name="policy_number" id="policy_number" value="{{ old('policy_number', $insurance->policy_number) }}"
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
                            value="{{ old('start_date', $insurance->start_date->format('Y-m-d')) }}"
                            class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required>
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ old('end_date', $insurance->end_date->format('Y-m-d')) }}"
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
                                    'dental_care' => 'Dental Care',
                                    'vision_care' => 'Vision Care',
                                    'mental_health' => 'Mental Health Services',
                                    'physical_therapy' => 'Physical Therapy'
                                ];
                            @endphp

                            @foreach($services as $key => $label)
                                <div class="flex items-center">
                                    <input type="checkbox" name="coverage_details[{{ $key }}]" id="{{ $key }}"
                                        value="1" {{ isset($insurance->coverage_details[$key]) && $insurance->coverage_details[$key] ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="{{ $key }}" class="ml-2 block text-sm text-gray-900">
                                        {{ $label }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('insurance.show', $insurance) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Insurance
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
