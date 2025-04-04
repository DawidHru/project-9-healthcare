@extends('layouts.app')

@section('title', 'Add Medical Equipment')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">Add New Medical Equipment</h1>
        <a href="{{ route('medical-equipment.index') }}" class="text-white hover:text-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-medium text-gray-700">Equipment Details</h2>
        </div>
        
        <div class="p-6">
            <form action="{{ route('medical-equipment.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Equipment Name*</label>
                        <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type*</label>
                        <input type="text" name="type" id="type" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number*</label>
                        <input type="text" name="serial_number" id="serial_number" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase Date*</label>
                        <input type="date" name="purchase_date" id="purchase_date" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="last_maintenance" class="block text-sm font-medium text-gray-700">Last Maintenance</label>
                        <input type="date" name="last_maintenance" id="last_maintenance" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="next_maintenance" class="block text-sm font-medium text-gray-700">Next Maintenance</label>
                        <input type="date" name="next_maintenance" id="next_maintenance" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status*</label>
                        <select name="status" id="status" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="available">Available</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="retired">Retired</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location*</label>
                        <input type="text" name="location" id="location" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label for="usage_instructions" class="block text-sm font-medium text-gray-700">Usage Instructions</label>
                    <textarea name="usage_instructions" id="usage_instructions" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('usage_instructions', $equipment->usage_instructions ?? '') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Detailed instructions on how to properly use this equipment.</p>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="window.location='{{ route('medical-equipment.index') }}'" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </button>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save Equipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection