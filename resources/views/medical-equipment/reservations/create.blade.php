@extends('layouts.app')

@section('title', 'Create Equipment Reservation')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">New Equipment Reservation</h1>
        <a href="{{ route('medical-equipment.reservations.index') }}" class="text-white hover:text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-700">Reservation Details</h2>
        </div>
        
        <div class="p-6">
            <form action="{{ route('medical-equipment.reservations.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="staff_id" value="1">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="equipment_id" class="block text-sm font-medium text-gray-700">Equipment*</label>
                        <select name="equipment_id" id="equipment_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Equipment</option>
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->type }}) - {{ $item->status }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time*</label>
                        <input type="datetime-local" name="start_time" id="start_time" required min="{{ now()->format('Y-m-d\TH:i') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700">End Time*</label>
                        <input type="datetime-local" name="end_time" id="end_time" required min="{{ now()->format('Y-m-d\TH:i') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose*</label>
                        <input type="text" name="purpose" id="purpose" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="window.location='{{ route('medical-equipment.reservations.index') }}'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Reservation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        
        startTimeInput.addEventListener('change', function() {
            endTimeInput.min = this.value;
        });
    });
</script>
@endpush