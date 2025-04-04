@extends('layouts.app')

@section('title', 'Issue Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Issue #{{ $issue->id }}</h1>
            <p class="text-gray-600">Reported on {{ $issue->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('medical-equipment.show', $issue->equipment) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Equipment
            </a>
            @if($issue->status !== 'closed')
                <a href="{{ route('equipment-issues.edit', $issue) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit Issue
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Issue Details Card -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-700">Issue Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Equipment</h3>
                            <p class="mt-1 text-sm text-gray-900">
                                <a href="{{ route('medical-equipment.show', $issue->equipment) }}" class="text-blue-600 hover:underline">
                                    {{ $issue->equipment->name }} ({{ $issue->equipment->serial_number }})
                                </a>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Reported By</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $issue->reporter->user->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Severity</h3>
                            <p class="mt-1 text-sm text-gray-900">
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
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Status</h3>
                            <p class="mt-1 text-sm text-gray-900">
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
                            </p>
                        </div>
                        @if($issue->resolved_by)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Resolved By</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $issue->resolver->user->name ?? 'Unknown' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Resolved At</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $issue->resolved_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500">Description</h3>
                        <div class="mt-1 p-4 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-900 whitespace-pre-line">{{ $issue->description }}</p>
                        </div>
                    </div>
                    
                    @if($issue->resolution_notes)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-500">Resolution Notes</h3>
                        <div class="mt-1 p-4 bg-gray-50 rounded-md">
                            <p class="text-sm text-gray-900 whitespace-pre-line">{{ $issue->resolution_notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Status Update Card -->
        <div>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-700">Update Status</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('equipment-issues.update-status', $issue) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <input type="hidden" name="resolved_by" value="1">
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status*</label>
                                <select name="status" id="status" required 
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="reported" {{ $issue->status == 'reported' ? 'selected' : '' }}>Reported</option>
                                    <option value="in_progress" {{ $issue->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $issue->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    <option value="closed" {{ $issue->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>
                            
                            <div id="resolutionNotesContainer" style="{{ in_array($issue->status, ['in_progress', 'resolved', 'closed']) ? '' : 'display: none;' }}">
                                <div>
                                    <label for="resolution_notes" class="block text-sm font-medium text-gray-700">
                                        Resolution Notes*
                                        <span class="text-xs text-gray-500">(Required when resolving, closing, or in progress)</span>
                                    </label>
                                    <textarea name="resolution_notes" id="resolution_notes" rows="4"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Describe the resolution steps or final remarks...">{{ old('resolution_notes', $issue->resolution_notes) }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            
            <!-- Equipment Status Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-medium text-gray-700">Equipment Status</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Current Status</h3>
                            <p class="mt-1 text-sm text-gray-900 capitalize">
                                @if($issue->equipment->status == 'available')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Available
                                    </span>
                                @elseif($issue->equipment->status == 'in_use')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        In Use
                                    </span>
                                @elseif($issue->equipment->status == 'maintenance')
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
                            <p class="mt-1 text-sm text-gray-900">{{ $issue->equipment->location }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Last Maintenance</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $issue->equipment->last_maintenance ? $issue->equipment->last_maintenance->format('M d, Y') : 'Never' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const notesContainer = document.getElementById('resolutionNotesContainer');
    const resolutionNotes = document.getElementById('resolution_notes');
    const form = document.querySelector('form');
    
    // Toggle notes visibility based on status
    function toggleNotesVisibility() {
        if (statusSelect.value === 'resolved' || statusSelect.value === 'closed') {
            notesContainer.style.display = 'block';
            resolutionNotes.required = true;
        } else {
            notesContainer.style.display = 'none';
            resolutionNotes.required = false;
        }
    }
    
    // Initial check
    toggleNotesVisibility();
    
    // Event listener for status change
    statusSelect.addEventListener('change', toggleNotesVisibility);
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if ((statusSelect.value === 'resolved' || statusSelect.value === 'closed') && 
            !resolutionNotes.value.trim()) {
            e.preventDefault();
            alert('Please provide resolution notes when resolving or closing an issue');
            resolutionNotes.focus();
        }
    });
});
</script>
@endpush