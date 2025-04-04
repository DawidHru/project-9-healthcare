@extends('layouts.app')

@section('title', 'Edit ' . $equipment->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Edit {{ $equipment->name }}</h1>
        <a href="{{ route('medical-equipment.show', $equipment) }}" class="text-white hover:text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-black">Equipment Details</h2>
        </div>
        
        <div class="p-6">
            <form action="{{ route('medical-equipment.update', $equipment) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Equipment Name*</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $equipment->name) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type*</label>
                        <input type="text" name="type" id="type" value="{{ old('type', $equipment->type) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number*</label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $equipment->serial_number) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase Date*</label>
                        <input type="date" name="purchase_date" id="purchase_date" 
                        value="{{ old('purchase_date', $equipment->purchase_date instanceof \Carbon\Carbon ? $equipment->purchase_date->format('Y-m-d') : $equipment->purchase_date) }}" 
                        required 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="last_maintenance" class="block text-sm font-medium text-gray-700">Last Maintenance</label>
                        <input type="date" name="last_maintenance" id="last_maintenance" 
                        value="{{ old('last_maintenance', $equipment->last_maintenance instanceof \Carbon\Carbon ? $equipment->last_maintenance->format('Y-m-d') : $equipment->last_maintenance) }}" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="next_maintenance" class="block text-sm font-medium text-gray-700">Next Maintenance</label>
                        <input type="date" name="next_maintenance" id="next_maintenance" 
                        value="{{ old('next_maintenance', $equipment->next_maintenance instanceof \Carbon\Carbon ? $equipment->next_maintenance->format('Y-m-d') : $equipment->next_maintenance) }}" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status*</label>
                        <select name="status" id="status" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="available" {{ old('status', $equipment->status) == 'available' ? 'selected' : '' }}>Available</option>
                            {{-- <option value="in_use" {{ old('status', $equipment->status) == 'in_use' ? 'selected' : '' }}>In Use</option> --}}
                            <option value="maintenance" {{ old('status', $equipment->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="retired" {{ old('status', $equipment->status) == 'retired' ? 'selected' : '' }}>Retired</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location*</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $equipment->location) }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label for="usage_instructions" class="block text-sm font-medium text-gray-700">Usage Instructions</label>
                    <textarea name="usage_instructions" id="usage_instructions" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('usage_instructions', $equipment->usage_instructions ?? '') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Detailed instructions on how to properly use this equipment.</p>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="window.location='{{ route('medical-equipment.show', $equipment) }}'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-blue-600 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Update Equipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection