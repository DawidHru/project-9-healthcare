@extends('layouts.app')

@section('title', 'Reservation Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Reservation Details</h1>
            <p class="text-gray-600">ID: {{ $reservation->id }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('medical-equipment.reservations.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </a>
            @if($reservation->status == 'pending')
                <form action="{{ route('medical-equipment.reservations.approve', $reservation) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Approve
                    </button>
                </form>
                <form action="{{ route('medical-equipment.reservations.reject', $reservation) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Reject
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Reservation Details Card -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-700">Reservation Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Equipment</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->equipment->name }} ({{ $reservation->equipment->type }})</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Serial Number</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->equipment->serial_number }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Reserved By</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->staff->user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Status</h3>
                            <p class="mt-1 text-sm text-gray-900 capitalize">
                                @if($reservation->status == 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($reservation->status == 'approved')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @elseif($reservation->status == 'rejected')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Completed
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Start Time</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->start_time }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">End Time</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->end_time }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="text-sm font-medium text-gray-500">Purpose</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->purpose }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Equipment Details Card -->
        <div>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-700">Equipment Details</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Name</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->equipment->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Type</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->equipment->type }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Status</h3>
                            <p class="mt-1 text-sm text-gray-900 capitalize">
                                @if($reservation->equipment->status == 'available')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @elseif($reservation->equipment->status == 'in_use')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        In Use
                                    </span>
                                @elseif($reservation->equipment->status == 'maintenance')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Maintenance
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Retired
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Location</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->equipment->location }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Next Maintenance</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $reservation->equipment->next_maintenance ? $reservation->equipment->next_maintenance : 'Not scheduled' }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('medical-equipment.show', $reservation->equipment) }}" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            View Equipment Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection