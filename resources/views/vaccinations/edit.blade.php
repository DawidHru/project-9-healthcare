@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Vaccinatie bewerken</h1>
        <a href="{{ route('vaccinations.show', $vaccination) }}" class="text-white hover:text-gray-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Terug naar details
        </a>
    </div>

    <form action="{{ route('vaccinations.update', $vaccination) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Hidden fields voor patient_id en doctor_id -->
        <input type="hidden" name="patient_id" value="{{ $vaccination->patient_id }}">
        <input type="hidden" name="doctor_id" value="{{ $vaccination->doctor_id }}">

        <!-- Basisinformatie Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-medium text-gray-700">Basisinformatie</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Patiënt</label>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900">{{ $vaccination->patient->user->name }}</p>
                                <p class="text-xs text-gray-500">ID: {{ $vaccination->patient->id }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Arts</label>
                        <div class="mt-1 flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900">{{ $vaccination->doctor->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $vaccination->doctor->specialization }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vaccinatiedetails Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-medium text-gray-700">Vaccinatiedetails</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="vaccine_name" class="block text-sm font-medium text-gray-700 mb-1">Vaccinnaam</label>
                        <input type="text" name="vaccine_name" id="vaccine_name" value="{{ $vaccination->vaccine_name }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="lot_number" class="block text-sm font-medium text-gray-700 mb-1">Lotnummer</label>
                        <input type="text" name="lot_number" id="lot_number" value="{{ $vaccination->lot_number }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="administration_date" class="block text-sm font-medium text-gray-700 mb-1">Toedieningsdatum</label>
                        <input type="date" name="administration_date" id="administration_date" value="{{ $vaccination->administration_date }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="next_dose_date" class="block text-sm font-medium text-gray-700 mb-1">Datum volgende dosis</label>
                        <input type="date" name="next_dose_date" id="next_dose_date" value="{{ $vaccination->next_dose_date ? $vaccination->next_dose_date : '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
        </div>

        <!-- Actie knoppen -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('vaccinations.show', $vaccination) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Annuleren
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Wijzigingen opslaan
            </button>
        </div>
    </form>
</div>
@endsection