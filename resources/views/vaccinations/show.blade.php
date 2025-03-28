@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Vaccinatiedetails</h1>
        <a href="{{ route('vaccinations.index') }}" class="text-white hover:text-gray-500 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Terug naar overzicht
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-700">Vaccinatiegegevens</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Patient Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Patiëntinformatie</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Naam</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $vaccination->patient->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Geboortedatum</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $vaccination->patient->date_of_birth }}</p>
                        </div>
                    </div>
                </div>

                <!-- Vaccination Details -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Vaccinatiedetails</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Vaccin</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $vaccination->vaccine_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Toedieningsdatum</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $vaccination->administration_date }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Lotnummer</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $vaccination->lot_number ?? 'Onbekend' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Volgende dosis</p>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($vaccination->next_dose_date)
                                    @if($vaccination->next_dose_date < $vaccination->administration_date)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $vaccination->next_dose_date }} (Vervallen)
                                        </span>
                                    @else
                                        {{ $vaccination->next_dose_date > $vaccination->administration_date }}
                                        <span class="text-gray-500 ml-2">{{ $vaccination->next_dose_date }}</span>
                                    @endif
                                @else
                                    Vandaag
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Toegediend door</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $vaccination->doctor->user->name }}
                                <span class="text-gray-500">({{ $vaccination->doctor->specialization }})</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
            <div>
                <a href="{{ route('vaccinations.patient.history', ['patient' => $vaccination->patient->id, 'vaccination_id' => $vaccination->id]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                    </svg>
                    Volledige geschiedenis
                </a>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('vaccinations.edit', $vaccination) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Bewerken
                </a>
            </div>
        </div>
    </div>
</div>
@endsection