@extends('layouts.app')

@section('title', $equipment->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ $equipment->name }}</h1>
            <p class="text-gray-600">{{ $equipment->type }} • Serial: {{ $equipment->serial_number }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('medical-equipment.index') }}" class="text-white hover:text-gray-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Terug naar overzicht
            </a>
            <a href="{{ route('medical-equipment.edit', $equipment) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Edit
            </a>
            <form action="{{ route('medical-equipment.destroy', $equipment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this equipment?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Equipment Details Card -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-700">Equipment Details</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Serial Number</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $equipment->serial_number }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Purchase Date</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $equipment->purchase_date }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Last Maintenance</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $equipment->last_maintenance ? $equipment->last_maintenance : 'Never' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Next Maintenance</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $equipment->next_maintenance ? $equipment->next_maintenance : 'Not scheduled' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Status</h3>
                            <p class="mt-1 text-sm text-gray-900 capitalize">
                                @if($equipment->status == 'available')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @elseif($equipment->status == 'in_use')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        In Use
                                    </span>
                                @elseif($equipment->status == 'maintenance')
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
                            <p class="mt-1 text-sm text-gray-900">{{ $equipment->location }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Maintenance Log Form -->
            <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-700">Log Maintenance</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('medical-equipment.log-maintenance', $equipment) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="maintenance_date" class="block text-sm font-medium text-gray-700">Maintenance Date*</label>
                                <input type="date" name="maintenance_date" id="maintenance_date" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="next_maintenance" class="block text-sm font-medium text-gray-700">Next Maintenance*</label>
                                <input type="date" name="next_maintenance" id="next_maintenance" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Log Maintenance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
            
            <!-- Current Reservation Card -->
            @if($equipment->activeReservation)
                <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
                        <h2 class="text-lg font-medium text-blue-700">Currently Reserved</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Reserved By</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $equipment->activeReservation->staff->user->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Time Period</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $equipment->activeReservation->start_time }} - 
                                    {{ $equipment->activeReservation->end_time }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Purpose</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $equipment->activeReservation->purpose }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div> 
    
    {{-- <!-- Reservations History --> --}}
    <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-700">Reservation History</h2>
        </div>
        <div class="p-6">
            @if($reservations->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reserved By</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Period</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reservations as $reservation)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $reservation->staff->user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $reservation->start_time }} - 
                                        {{ $reservation->end_time }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reservation->purpose }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                 </div>
                
                <div class="mt-4">
                    {{ $reservations->links() }}
                </div>
            @else
                <p class="text-sm text-gray-500">No reservation history found.</p>
            @endif
        </div>
    </div>
    <!-- Issues Section -->
    <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-700">Equipment Issues</h2>
            <a href="{{ route('equipment-issues.create',['equipment' => $equipment]) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Report New Issue
            </a>
        </div>
        
        <div class="p-6">
            @if($equipment->issues->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($equipment->issues as $issue)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $issue->created_at->format('Y-m-d') }}</div>
                                    <div class="text-sm text-gray-500">by {{ $issue->reporter->user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $severityColors = [
                                            'low' => 'bg-green-100 text-green-800',
                                            'medium' => 'bg-yellow-100 text-yellow-800',
                                            'high' => 'bg-orange-100 text-orange-800',
                                            'critical' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $severityColors[$issue->severity] }}">
                                        {{ ucfirst($issue->severity) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'reported' => 'bg-gray-100 text-gray-800',
                                            'in_progress' => 'bg-blue-100 text-blue-800',
                                            'resolved' => 'bg-green-100 text-green-800',
                                            'closed' => 'bg-purple-100 text-purple-800'
                                        ];
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$issue->status] }}">
                                        {{ str_replace('_', ' ', ucfirst($issue->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('equipment-issues.show', $issue) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                    @if($issue->status !== 'closed')
                                        <a href="{{ route('equipment-issues.edit', $issue) }}" class="text-yellow-600 hover:text-yellow-900">Update</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-500">No issues reported for this equipment.</p>
            @endif
        </div>
    </div>
</div>
@endsection